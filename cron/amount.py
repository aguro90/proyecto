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
#aqui tenemos todas las cuentas
for row in cur.fetchall():
	auth = OAuthHandler(consumer_key, consumer_secret)
	auth.set_access_token(row[4], row[5])
	api = tweepy.API(auth, wait_on_rate_limit=True)
	user = api.me()
	
#ahora vamos a seguir al numero de personas que tenga en su perfil
	cantidad = user.followers_count
	
#calculamos el numero de seguidores que tiene y lo insertamos para obtener el grafico del index.
	cur.execute("insert into followers values("+str(row[0])+",now(),"+str(cantidad)+")")
	
#ahora vamos a comprobar los que seguimos anteriormente 
#obtenemos el numero de dias que se quiere esperar
	cur.execute("select check_after from users,accounts where users.user_id=accounts.user_id and accounts.id_account="+str(row[0]))
	for row4 in cur.fetchall():
		cft=row4[0]
	print (cft)
	#obtenemos los id que cumplen que han pasado el numero de dias para comprobar 
	sql="select id_followed from followed_tasks,tasks,accounts where followed_tasks.id_task=tasks.id_task and tasks.id_account=accounts.id_account and accounts.id_account="+str(row[0])+" and followed_tasks.checked=0 and followed_tasks.follow_date is not null AND  followed_tasks.follow_date <= SUBDATE(now(), interval "+str(cft)+"  DAY)"
	cur.execute(sql)
	for row3 in cur.fetchall():
			print ("comprobando "+row3[0])
			status=api.show_friendship(source_id=str(row3[0]),target_id=str(row[0]))
			if status[0].following == True:
			#si nos ha devuelto el follow cambiamos el checked a 1 para no volver a procesarlo y aniadimos 1 al campo follow_back
				cur.execute("update followed_tasks,tasks set followed_tasks.checked = 1,followed_tasks.follow_back = 1 where followed_tasks.id_followed = "+row3[0]+" and tasks.id_account= "+row[0])
			else:
			#si no nos sigue tras esto eliminamos la relacion y hacemos update del campo checked a 1
				api.destroy_friendship(row3[0])
				cur.execute("update followed_tasks,tasks set followed_tasks.checked = 1 where followed_tasks.id_followed = "+row3[0]+" and tasks.id_account= "+row[0])

#ahora vamos a seguir al numero de personas que tenga en su perfil
	cur.execute("select max_per_day from users,accounts where users.user_id=accounts.user_id and accounts.id_account="+str(row[0]))
	for row1 in cur.fetchall():
		mpd=row1[0]
#	ahora sacamos los perfiles a seguir pero con el limite que el tenga
	cur.execute("select id_followed from followed_tasks,tasks,accounts where followed_tasks.id_task=tasks.id_task and tasks.id_account=accounts.id_account and accounts.id_account="+str(row[0])+" and followed_tasks.checked=0 and followed_tasks.follow_date is null limit "+str(mpd))
	for row2 in cur.fetchall():
		status=api.show_friendship(source_id=str(row[0]),target_id=str(row2[0]))
		if status[0].following == True:
			#print ("Lo sigues a "+row2[0])
			#Si ya lo seguimos marcamos el atributo checked para que no vuelva a salir
			#nos da igual (de echo favorece)que actualizamos el checked sin id_task pero si con id_account para que si lo encuentra con otra tarea no lo tenga en cuenta
			#importante error: la fecha tiene que ser null para esta condicion 
			cur.execute("update followed_tasks,tasks set followed_tasks.checked = 1 where followed_tasks.id_followed = "+row2[0]+" and tasks.id_account= "+row[0])
		else:
			#print ("No lo sigues")
			#print ("no sigues a "+row2[0])
			#lo seguimos y actualizamos el campo de la fecha y dejamos el campo checked a 0 para comprobarlo despues
			#este try es debido a que si un usuario nos tiene bloqueados o no podemos seguirlo sigua funcionando
			try:
				api.create_friendship(row2[0])
				cur.execute("update followed_tasks set followed_tasks.follow_date = now() where followed_tasks.id_followed = "+row2[0])
			except Exception ,e:
				pass

#confirmamos todos los cambios
db.commit()



	

db.close()
