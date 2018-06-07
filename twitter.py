import argparse
import MySQLdb
import tweepy
from tweepy import OAuthHandler

db = MySQLdb.connect(
                user='twitter_accounts',
                passwd='twitter.accounts1@',
                host='localhost',
                db='twitter')
cur = db.cursor()

parser = argparse.ArgumentParser(description='Introduce parametros para interactuar con tweepy')

#no olvidar ,required=TRUE en las dos primeras
parser.add_argument('-id_task', help='Id de la tarea en la bdd',required=True)
parser.add_argument('-cuenta', help='Nombre de la cuenta',required=True)
parser.add_argument('-lat', help='Latitud , puede no encontrarse',default="LAT")
parser.add_argument('-lng', help='Longitud , puede no encontrarse',default="LNG")
parser.add_argument('-radio', help='Radio en las coordenadas indicadas',default="NO")
parser.add_argument('-hashtag', help='Hashtag para buscar',default="NO")
parser.add_argument('-interacciones', help='Latitud , puede no encontrarse',default="NO")
args = vars(parser.parse_args())

#obtenemos credenciales de la api
consumer_key = '0NLqf3W3RusCKFfk2cj1NAXVl'
consumer_secret = '2JLKstfcDXpZTpbRFUHk9khe64N9JHDI8eStNhKPGCtF5nnKoB'

#obtenemos las credenciales de la cuenta
sql="select oauth_token , oauth_secret from accounts where id_account = '"+args['cuenta']+"'"
cur.execute(sql)
result_set = cur.fetchall()
for row in result_set:
	access_token=row[0] 
	access_secret=row[1]
	
#print ("Access_token = "+access_token)
#print ("Access_secret = "+access_secret)

#realizamos la conexion
auth = OAuthHandler(consumer_key, consumer_secret)
auth.set_access_token(access_token, access_secret) 
api = tweepy.API(auth, wait_on_rate_limit=True)
#(wait on rate limit hace que si alcanzamos el numero de peticiones maximo ,espere sin finalizar para poder continuar en los siguientes 15 minutos)

#comenzamos con viendo el tipo de consulta que se quiere hacer y separamos en funcion

#consulta solo con hashtag sin interacciones
if  (args['hashtag']!="NO") and (args['lat']=="LAT") and (args['lng']=="LNG")and(args['interacciones']=="NO"):
	#print("Quieres una con hashtag "+args['hashtag']+" y sin coordenadas y sin interacciones")
	
	for tweet in  tweepy.Cursor(api.search,q=args['hashtag']).items(30):
		#comprobamos si esta en la tabla seguidos y si no lo insertamos
		sql="select count(*) from followed where id_followed ='"+str(tweet.user.id)+"'"
		cur.execute(sql)
		result_set = cur.fetchall()
		for row in result_set:
			count=row[0] 
		if count== 0:
			sql="insert into followed values("+str(tweet.user.id)+",'"+str(tweet.user.screen_name)+"')"
			cur.execute(sql)
		#debemos mirar que si en la busqueda nos da mas de un tweet del mismo id no se aniadan 2 veces el mismo usuario con la misma tarea
		sql="select count(*) from followed_tasks where id_followed ='"+str(tweet.user.id)+"' and id_task="+str(args['id_task'])
		cur.execute(sql)
		result_set = cur.fetchall()
		for row in result_set:
			count=row[0] 
		if count== 0:
			sql="insert into followed_tasks values("+str(tweet.user.id)+","+str(args['id_task'])+",now(),0)"
			cur.execute(sql)
		db.commit()
	print("Ejecutado correctamente")
	
#consulta con hashtag e interacciones
if (args['hashtag']!="NO") and (args['lat']=="LAT") and (args['lng']=="LNG")and(args['interacciones']=="SI"):
	#print("Quieres una con hashtag "+args['hashtag']+" y sin coordenadas y con interacciones")

	for tweet in  tweepy.Cursor(api.search,q=args['hashtag']).items(30):
		sql="select count(*) from followed where id_followed ='"+str(tweet.user.id)+"'"
		rows = cur.execute(sql)
		if rows == 0:
			sql="insert into followed values("+str(tweet.user.id)+","+str(tweet.user.screen_name)+")"
			cur.execute(sql)
		sql="insert into followed_tasks values('"+str(tweet.user.id)+"','"+str(args['id_task'])+"',now(),false)"
		cur.execute(sql)
		for reTweet in api.retweets(tweet.id):
			sql="select count(*) from followed where id_followed ='"+str(reTweet.user.id)+"'"
			rows = cur.execute(sql)
			if rows == 0:
				sql="insert into followed values("+str(reTweet.user.id)+","+str(+reTweet.user.screen_name)+")"
				cur.execute(sql)
			sql="insert into followed_tasks values('"+str(reTweet.user.id)+"','"+str(args['id_task'])+"',now(),false)"
			cur.execute(sql)
		
	
	
#consulta solo con localizacion
if (args['hashtag']=="NO") and (args['lat']!="LAT") and (args['lng']!="LNG")and(args['interacciones']=="NO"):
	#print("Quieres una con hashtag  coordenadas y sin hashtag")
	
	coord="'"+args['lat']+","+args['lng']+","+args['radio']+"'"
	for tweet in tweepy.Cursor(api.search, geocode=coord).items(30):
		sql="select count(*) from followeds where id_followed ='"+str(tweet.user.id)+"'"
		rows = cur.execute(sql)
	if rows == 0:
		sql="insert into followed values("+str(tweet.user.id)+","+str(tweet.user.screen_name)+")"
		cur.execute(sql)
	sql="insert into followed_tasks values('"+str(tweet.user.id)+"','"+str(args['id_task'])+"',now(),false)"
	cur.execute(sql)

	
#consulta con hastag localizacion y sin interacciones
if (args['hashtag']!="NO") and (args['lat']!="LAT") and (args['lng']!="LNG")and(args['interacciones']=="NO"):
	#print("Quieres una consulta con hashtag, ubicacion y sin interacciones")
	coord="'"+args['lat']+","+args['lng']+","+args['radio']+"'"
	for tweet in tweepy.Cursor(api.search,q=args['hashtag'],geocode=coord).items(30):
		sql="select count(*) from followed where id_followed ='"+str(tweet.user.id)+"'"
	rows = cur.execute(sql)
	if rows == 0:
		sql="insert into followed values("+str(tweet.user.id)+","+str(tweet.user.screen_name)+")"
		cur.execute(sql)
	sql="insert into followed_tasks values('"+str(tweet.user.id)+"','"+str(args['id_task'])+"',now(),false)"
	cur.execute(sql)
	
#consulta con hashtag,localizacion e interacciones
if (args['hashtag']!="NO") and (args['lat']!="LAT") and (args['lng']!="LNG")and(args['interacciones']=="SI"):
	#print("Quieres una consulta con hashtag, ubicacion y con interacciones")
	coord="'"+args['lat']+","+args['lng']+","+args['radio']+"'"
	for tweet in tweepy.Cursor(api.search,q=args['hashtag'],geocode=coord).items(30):
		sql="select count(*) from followed where id_followed ='"+str(tweet.user.id)+"'"
	rows = cur.execute(sql)
	if rows == 0:
		sql="insert into followed values("+str(tweet.user.id)+","+str(tweet.user.screen_name)+")"
		cur.execute(sql)
	sql="insert into followed_tasks values('"+str(tweet.user.id)+"','"+str(args['id_task'])+"',now(),false)"
	cur.execute(sql)
	for reTweet in api.retweets(tweet.id):
		sql="select count(*) from followed where id_followed ='"+str(reTweet.user.id)+"'"
		rows = cur.execute(sql)
		if rows == 0:
			sql="insert into followed values("+str(reTweet.user.id)+","+str(+reTweet.user.screen_name)+")"
			cur.execute(sql)
		sql="insert into followed_tasks values('"+str(reTweet.user.id)+"','"+str(args['id_task'])+"',now(),false)"
		cur.execute(sql)