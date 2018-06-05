import MySQLdb

import tweepy
from tweepy import OAuthHandler

consumer_key = '0NLqf3W3RusCKFfk2cj1NAXVl'
consumer_secret = '2JLKstfcDXpZTpbRFUHk9khe64N9JHDI8eStNhKPGCtF5nnKoB'

db = MySQLdb.connect(
		user='twitter_accounts',
		passwd='twitter.accounts1@',
		host='127.0.0.1',
		db='twitter')

cur = db.cursor()

cur.execute("select * from accounts")

for row in cur.fetchall():
	auth = OAuthHandler(consumer_key, consumer_secret)
	auth.set_access_token(row[4], row[5])
	api = tweepy.API(auth, wait_on_rate_limit=True)

	user = api.me()

	cantidad = user.followers_count

	cur = db.cursor()

	cur.execute("insert into followers values("+str(row[0])+",now(),"+str(cantidad)+")")

db.commit()

db.close()
