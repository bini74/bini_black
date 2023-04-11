import sys
import os
from time import localtime, strftime, sleep
import Adafruit_DHT
import requests

# Reference de la sonde (DHT22), a ne pas modifier
SENSOR = 11

# Numero de la broche sur laquelle la sonde est soudee
PIN = 4

# Identifiant de la piece dont les donnees sont capturees
ROOM = 'Terrarium'

# URL du serveur PHP et MySQL
BASE_URL = 'https://bini.black/Releve/Terrarium/raspberry.php'

# Fichier utilise pour stocker les donnees n'ayant pu etre transmise au serveur
DATAS_NOT_SENT_FILE = '/home/pi/error_sonde'

# Nombre de tentative maximum de capture
NUMBER_OF_TRIES = 4

while True:
    current_date = strftime("%Y-%m-%d %H:%M:%S", localtime())
    formatted_humidity = ''
    formatted_temperature = ''

    # Interroge la sonde pour obtenir la temperature et le taux d'humidite courante
    # Si necessaire, reessaye 15 fois en attendant 2 secondes entre chaque tentatives
    humidity, temperature = Adafruit_DHT.read_retry(SENSOR, PIN)

    # La capture des donnees peut ne pas fonctionner (cas rare), au besoin tente 'nbTries' fois
    i = 1
    while (humidity is None or temperature is None) and i < NUMBER_OF_TRIES:
        humidity, temperature = Adafruit_DHT.read_retry(SENSOR, PIN)
        i = i + 1

    # Si les donnees ont pu etre capturees
    if humidity is not None and temperature is not None:
        # Formattage des donnees pour transmission au serveur
        formatted_humidity = '{0:0.0f}'.format(humidity)
        formatted_temperature = '{0:0.0f}'.format(temperature)
        data = {'temperature': formatted_temperature, 'humidity': formatted_humidity}
        print(f"Envoi de données au serveur : {data}")
        headers = {'Content-type': 'application/json'}

        try:
            # Envoi des donnees collectees au serveur PHP et MySQL
            response = requests.post(BASE_URL, json=data, headers=headers)

            if response.status_code == 200:
                print('Données enregistrées avec succès')
            else:
                print('Erreur lors de l\'enregistrement des données')

                # En cas d'erreur lors de l'enregistrement des données, celles-ci sont conservees dans le fichier des erreurs afin d'etre transmises des que la connexion est a nouveau fonctionnelle
                f = open(DATAS_NOT_SENT_FILE, 'a')
                f.write(current_date + ';' + ROOM + ';' + formatted_temperature + ';' + formatted_humidity + '\n')
                f.close()
        except:
            print("Erreur lors de l'envoi des données")

            # En cas d'erreur lors de l'envoi des donnees, celles-ci sont conservees dans le fichier des erreurs afin d'etre transmises des que la connexion est a nouveau fonctionnelle
            f = open(DATAS_NOT_SENT_FILE, 'a')
            f.write(current_date + ';' + ROOM + ';' + formatted_temperature + ';' + formatted_humidity + '\n')
            f.close()
