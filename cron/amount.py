import MySQLdb

db = MySQLdb.connect(
		user='twitter_accounts',
		passwd='twitter.accounts1@',
		host='127.0.0.1',
		db='twitter')

cur = db.cursor()

cur.execute("select * from accounts")

for row in cur.fetchall():
	print (row[0])
