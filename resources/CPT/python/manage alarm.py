import sys
import requests
import time
import simpleaudio
import json


# Main Program
try:
    state = 0
    url = 'http://127.0.0.1:8000/api/equipments/'
    while True:
        print("********** A LER ESTADO DOS ASPERSORES DE INCÊNDIO **********")
        r = requests.get(url + 'Aspersor%20de%20Incêncio');
        if(r.status_code == 200):

            # Test if there is a detected fire
            print("Estado: " + r.text)

             # If alarm state changed, save new value
            if(state != int(r.text)):
                state = int(r.text)
                
                data = { 'values': json.dumps([{ 'name': 'Alarme', 'value': state }]) }

                # Update database
                r = requests.post('http://127.0.0.1:8000/api/equipments/', data)
                if(r.status_code == 200):
                    print("*** Alarme atualizado com sucesso ***")
                else:
                    print("ERRO: Falha ao atualizar estado do alarme. -> " + r.text)

            if(state == 1):
                print("### A TOCAR ALARME ###")

                # PLAY ALARM
                wave = simpleaudio.WaveObject.from_wave_file('alarm.wav')
                obj = wave.play()
                obj.wait_done()

        else:
            print("Não foi possível pedir os dados à API")

        time.sleep(2)

except KeyboardInterrupt:
    print("********** Programa terminado pelo utilizador **********")
except:
    print("Ocorreu um erro:", sys.exc_info())
finally:
    print("********** Fim do programa **********")


