#!/bin/python3

from base64 import b64encode
from re import findall
from glob import glob
from time import sleep
import pymysql
import json

DB = {
	'host': '127.0.0.1',
	'user': 'root',
	'pass': 'toor',
	'database': 'ctf_monitor'
}
LOG_PATH = [
	"resource/web1_*.log"
]
NEW_LOG = []
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

def insert(content):
	global con
	sql = "INSERT INTO web_challenge(`time`, `status`, `method`, `rich_data`, `raw_data`, `response`) VALUES (%s, %s, %s, %s, %s, %s)"
	value = (content['time'], content['status'], content['method'], content['rich_data'], content['raw_data'], content['response'])
	con.cursor().execute(sql, value)
	con.commit()

def rfile(filename):
	log = open(filename, 'rb')
	req_package = ''
	for line in log:
		if '='*25 in line.decode():
			yield req_package
			req_package = ''
			continue
		req_package += line.decode()

def regex(pattern, string):
	return ''.join(findall(pattern, string)).strip()

def parse_data(req_package):
	global con
	if req_package.strip() == '': return
	time = regex('\[(\d+:\d+:\d+)\]', req_package)
	method = regex(time + '\]\s([A-Z]+)\s', req_package)
	status = regex('^Status: (.*)', req_package)
	raw_data = req_package.split('>>>>')[0]
	response = req_package.split('>>>>')[1]
	rich_data = 'URL: %s\nCOOKIE: %s\nDATA: %s\nFILE: %s'\
	% (regex(method + '\s(.*)', req_package), \
	   regex('Cookie: (.*)', req_package), \
	   regex('Data: (.*)', req_package), \
	   regex('File: (.*)', req_package),\
	)
	content = {
		'time': time,
		'method': method,
		'status': status,
		'raw_data': b64encode(raw_data.encode()).decode(),
		'response': b64encode(response.encode()).decode(),
		'rich_data': b64encode(rich_data.encode()).decode()
	}
	insert(content)

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

if __name__ == '__main__':
	con = connect()
	while True:
		load_log()
		for logfile in NEW_LOG:
			for pkg in rfile(logfile):
				parse_data(pkg)
		sleep(5)
