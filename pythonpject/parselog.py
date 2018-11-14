#!/bin/python3

from base64 import b64encode
from re import findall, split
from glob import glob
from time import sleep
import pymysql
import json
from paramiko import SSHClient, AutoAddPolicy, SFTPClient
import threading
import os
import hashlib

SSH = {
	'host': '10.0.0.12',
	'port': 22,
	'user': 'root',
	'pass': 'toor',
	'path_log': '/root/ex50/archive_log'
}
DB = {
	'host': '127.0.0.1',
	'user': 'root',
	'pass': 'toor',
	'database': 'ctf_monitor'
}
LOG_PATH = [
	"resource/flask_full_*.txt",
	"resource/http_full_*.log"
]
NEW_LOG = []
CRLF = '\r\n'
try:
	OLD_LOG = json.loads(open('old.log', 'r').read())
except:
	OLD_LOG = []

def connect():
	global DB, con
	con = pymysql.connect(host=DB['host'], user=DB['user'], password=DB['pass'], db=DB['database'])
	con.cursor().execute("create table if not exists web_challenge (\
				`id` int(100) AUTO_INCREMENT,\
				`time` varchar(25) DEFAULT NULL,\
				`status` varchar(25) DEFAULT 'Safe',\
				`method` varchar(25) DEFAULT 'GET',\
				`rich_data` text,\
				`raw_data` text,\
				`response` text,\
				PRIMARY KEY (id))")
	return con

def insertDB(content):
	global con
	sql = "INSERT INTO web_challenge(`time`, `status`, `method`, `rich_data`, `raw_data`, `response`) VALUES (%s, %s, %s, %s, %s, %s)"
	value = (content['time'], content['status'], content['method'], content['rich_data'], content['raw_data'], content['response'])
	con.cursor().execute(sql, value)
	con.commit()
	print('[+] Inserted to database')

def rfile(filename):
	log = open(filename, 'rb')
	req_package = ''
	for line in log:
		line = line.decode().rstrip()
		if '='*64 in line or line.startswith('==========='):
			yield req_package
			req_package = ''
			continue
		req_package += line + CRLF
	yield req_package

def regex(pattern, string):
	result = findall(pattern, string)
	if len(result) > 0:
		return result[0].strip()
	return 'None'

def parse_data(req_package):
	global con, CRLF
	if req_package.strip() == '': return

	raw_request = split('------Response-----|>>>>', req_package)[0]
	response = split('------Response-----|>>>>', req_package)[1]

	time = regex('\[(\d+:\d+:\d+)\]', req_package)
	method = regex(time + '\]\s([A-Z]+)\s', req_package)
	status = regex('^Status: (.*)', req_package)
	url = regex(method + '\s(.*)', req_package)
	host = regex('Host: (.*)', req_package)
	cookie = regex('Cookie: (.*)', req_package)
	data = regex('Data: (.*)', req_package)
	file = regex('File: (.*)', req_package)
	if method.upper() == 'POST':
		post_data = raw_request.split(CRLF+CRLF)
		if len(post_data) > 1:
			if data == 'None':
				data = post_data[1].strip()
			else:
				data += post_data[1].strip()
	rich_data = f'URL: {url}\r\nHost: {host}\r\nCOOKIE: {cookie}\r\nDATA: {data}\r\nFILE: {file}'

	content = {
		'time': time,
		'method': method,
		'status': status,
		'raw_data': b64encode(raw_request.encode()).decode(),
		'response': b64encode(response.encode()).decode(),
		'rich_data': b64encode(rich_data.encode()).decode()
	}
	insertDB(content)

def load_log():
	global LOG_PATH, NEW_LOG, OLD_LOG
	for logfile in LOG_PATH:
		NEW_LOG += [f for f in glob(logfile)]
	temp = NEW_LOG[:]
	for logfile in temp:
		if logfile in OLD_LOG:
			NEW_LOG.remove(logfile)
		else:
			OLD_LOG.append(logfile)
# 	store list log
	open('old.log', 'w').write(json.dumps(OLD_LOG))

def download_log():
	global SSH, OLD_LOG
	ssh = SSHClient()
	ssh.set_missing_host_key_policy(AutoAddPolicy())
	try:
		ssh.connect(SSH['host'], username=SSH['user'], password=SSH['pass'])
	except:
		return 'SSH fail'
	while True:
		stdin, stdout, stderr = ssh.exec_command('ls ' + SSH['path_log'])
		filelist = stdout.read().splitlines()
		for filename in filelist:
			filename = ''.join([chr(c) for c in filename])
			if filename in [os.path.basename(i) for i in OLD_LOG]:
				continue
			transport = ssh.get_transport()
			sftp = SFTPClient.from_transport(transport)
			sftp.get(SSH['path_log'] + '/' + filename, './resource/' + filename)
			print('[+] Copied ' + filename)

def main():
	global con
	con = connect()
	while True:
		load_log()
		for logfile in NEW_LOG:
			for pkg in rfile(logfile):
				parse_data(pkg)

if __name__ == '__main__':
	threading.Thread(target=download_log).start()
	threading.Thread(target=main).start()
