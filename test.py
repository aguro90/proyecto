import requests
import tweepy
from tweepy import OAuthHandler
from credenciales import *

auth = tweepy.OAuthHandler(consumer_key, consumer_secret)

try:
    redirect_url = auth.get_authorization_url()
except tweepy.TweepError:
    print ('Error! Failed to get request token.')

print(redirect_url)
#verifier = request.GET.get('oauth_verifier')