import cv2 as cv
import requests
import time
import sys

def send_file(file):
    url="http://127.0.0.1:8000/api/equipments/uploadWebcam"
    files = { 'image': open(file, 'rb') }
    r = requests.post(url, files=files)
    print(r.text)
    if r.status_code == 200:
        print("OK: POST realizado com sucesso")
        print("Status: " + str(r.status_code))
    else:
        print("ERRO: Não foi possível realizar o pedido.")
        print("Status: " + str(r.status_code))

try:
    file='webcam.jpg'

    while True:
        camera = cv.VideoCapture(0)
        ret, image = camera.read()
        cv.imwrite(file, image)
        camera.release()
        cv.destroyAllWindows()
        send_file(file)
        time.sleep(3)
    
except KeyboardInterrupt: # caso haja interrupção de teclado CTRL+C
    print("Programa terminado pelo utilizador")
except: # caso haja um erro qualquer
    print("Ocorreu um erro:", sys.exc_info())
finally: # executa sempre, independentemente se ocorreu exception
    print("Fim do programa")
