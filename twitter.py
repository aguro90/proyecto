#estos modulos siempre ya que son para autenticarse contra la api
import tweepy
from tweepy import OAuthHandler
from credenciales import *

auth = OAuthHandler(consumer_key, consumer_secret)
auth.set_access_token(access_token, access_secret) 
api = tweepy.API(auth, wait_on_rate_limit=True)
#################################################################3

#a partir de aqui lo que necesitemos

#bloque que lee nuestro TL 
#for status in tweepy.Cursor(api.home_timeline).items(10):
    # Process a single status
#    print(status.text)
##########################

#consulta por hashtag
# For loop to iterate over tweets with #ocean, limit to 10
#for tweet in tweepy.Cursor(api.search,q='#ocean').items(10):

# Print out usernames of the last 10 people to use #ocean y texto
    #print('Tweet by: @' + tweet.user.screen_name,end="\n")
    #print(tweet.text,end="\n")
    #print(tweet.created_at,end="\n")
    #print(tweet.user.id,end="\n")
    #print("\n")
###########################

#consulta por hashtag v2
#for tweet in tweepy.Cursor(api.search,
#                           q='#ocean',
#                           since='2016-11-25',
#                           until='2016-11-27',
#                           geocode='1.3552217,103.8231561,100km',
#                           lang='fr').items(10):
#    print('Tweet by: @' + tweet.user.screen_name)
############################

# ies GC: 37.89995,-4.753081
# hospital 37.908617,-4.793227
#if tweet.user.screen_name == "aldelam96":

#limite de 100 tweets cada 15 minutos
#consulta con tweets
for tweet in tweepy.Cursor(api.search, geocode='37.89995,-4.753081,1km').items(5):
	if (tweet.user.id != 218036519) and (tweet.user.id != 148165816):
		print (tweet.created_at)
		print (tweet.text,end="\n")
		print (tweet.user.screen_name,end="\n")
		print (tweet.user.id,end="\n")
		print (tweet.place.full_name,end="\n")
		print (tweet.coordinates,end="\n\n")