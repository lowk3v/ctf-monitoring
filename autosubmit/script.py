import requests
import re
from glob import glob
from time import sleep
from subprocess import Popen, PIPE

username = 'ACT.Warriors'
password = 'WGVaR8ym'
origin_url = 'https://scoreboard.svattt.com'
url_login = 'https://scoreboard.svattt.com/api/sign-in'
url_submit = 'https://scoreboard.svattt.com/api/challenge-submit'

proxy = {}

header = {
	'User-Agent': 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:62.0) Gecko/20100101 Firefox/62.0',
	'Accept': 'application/json, text/plain, */*',
	'Referer': 'https://scoreboard.svattt.com/',
	'Content-Type': 'application/x-www-form-urlencoded'
}

data_login = {
	'username': username,
	'password': password,
	'ci_token': ''
}
data_submit = {
	'flag': '',
	'ci_token': '',
	'id': '5'
}


def get_flag():
	return glob('flags/*')

def del_flag():
	stdout, stderr = Popen(['move', 'flags\\*', 'archive\\'], stdout=PIPE, stderr=PIPE, shell=True).communicate()
	print(stderr.decode())

def login():
	global data_submit
	# Init
	req = requests.session()
	res = req.get(origin_url, proxies=proxy)

	# Get token
	token = re.findall('ci_cookie=([a-f0-9]+)', res.headers['Set-Cookie'])[0]
	# print(token)
	data_login['ci_token'] = token 
	data_submit['ci_token'] = token

	# login
	res = req.post(url_login, data=data_login, proxies=proxy, headers=header)
	print(res.text)
	return req

def submit(req, flag):
	data_submit['flag'] = flag
	res = req.post(url_submit, data=data_submit, proxies=proxy, headers=header)
	print(flag, res.text, sep=': ')

if __name__ == '__main__':
	list_flag = get_flag()
	req = login()
	for item in list_flag:
		file_flag = open(item, 'r')
		for flag in file_flag:
			flag = flag.strip()
			if flag == '': continue
			submit(req, flag)
			sleep(6)
		file_flag.close()
	try: del_flag()
	except: pass
