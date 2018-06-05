import argparse
import MySQLdb

db = MySQLdb.connect(
                user='twitter_accounts',
                passwd='twitter.accounts1@',
                host='localhost',
                db='twitter')
cur = db.cursor()

parser = argparse.ArgumentParser(description='Introduce parametros para interactuar con tweepy')

#no olvidar ,required=TRUE en las dos primeras
parser.add_argument('-id_task', help='Id de la tarea en la bdd')
parser.add_argument('-cuenta', help='Nombre de la cuenta')
parser.add_argument('-lat', help='Latitud , puede no encontrarse',default="LAT")
parser.add_argument('-lng', help='Longitud , puede no encontrarse',default="LNG")
parser.add_argument('-hashtag', help='Hashtag para buscar',default="NO")
parser.add_argument('-interacciones', help='Latitud , puede no encontrarse',default="NO")
args = vars(parser.parse_args())

#comenzamos con viendo el tipo de consulta que se quiere hacer y separamos en funcion


#consulta solo con hashtag sin interacciones
if  (args['hashtag']!="NO") and (args['lat']=="LAT") and (args['lng']=="LNG")and(args['interacciones']=="NO"):
	print("Quieres una con hashtag "+args['hashtag']+" y sin coordenadas y sin interacciones")
#consulta con hashtag e interacciones
if (args['hashtag']!="NO") and (args['lat']=="LAT") and (args['lng']=="LNG")and(args['interacciones']=="SI"):
	print("Quieres una con hashtag "+args['hashtag']+" y sin coordenadas y con interacciones")
#consulta solo con localizacion
if (args['hashtag']=="NO") and (args['lat']!="LAT") and (args['lng']!="LNG")and(args['interacciones']=="NO"):
	print("Quieres una con hashtag  coordenadas y sin hashtag")
#consulta con hastag localizacion y sin interacciones
if (args['hashtag']!="NO") and (args['lat']!="LAT") and (args['lng']!="LNG")and(args['interacciones']=="NO"):
	print("Quieres una consulta con hashtag, ubicacion y sin interacciones")
#consulta con hashtag,localizacion e interacciones
if (args['hashtag']!="NO") and (args['lat']!="LAT") and (args['lng']!="LNG")and(args['interacciones']=="SI"):
	print("Quieres una consulta con hashtag, ubicacion y con interacciones")
