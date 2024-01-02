#!/usr/bin/env python3

import datetime
import subprocess
import time
import os.path
from os import path

RELAIS1_STATUS_DATEI = "/dev/shm/relais1_status.txt"
RELAIS2_STATUS_DATEI = "/dev/shm/relais2_status.txt"
RELAIS3_STATUS_DATEI = "/dev/shm/relais3_status.txt"
RELAIS4_STATUS_DATEI = "/dev/shm/relais4_status.txt"
RELAIS5_STATUS_DATEI = "/dev/shm/relais5_status.txt"
RELAIS6_STATUS_DATEI = "/dev/shm/relais6_status.txt"
RELAIS7_STATUS_DATEI = "/dev/shm/relais7_status.txt"
RELAIS8_STATUS_DATEI = "/dev/shm/relais8_status.txt"
LOG_ENDE = "/media/platte/schuppendaten/log_ende.txt"
LOG_RELAIS1 = "/media/platte/schuppendaten/status_relais1.log"
LOG_RELAIS2 = "/media/platte/schuppendaten/status_relais2.log"
LOG_RELAIS3 = "/media/platte/schuppendaten/status_relais3.log"
LOG_RELAIS4 = "/media/platte/schuppendaten/status_relais4.log"
LOG_RELAIS5 = "/media/platte/schuppendaten/status_relais5.log"
LOG_RELAIS6 = "/media/platte/schuppendaten/status_relais6.log"
LOG_RELAIS7 = "/media/platte/schuppendaten/status_relais7.log"
LOG_RELAIS8 = "/media/platte/schuppendaten/status_relais8.log"

def main():
    while True:
        time.sleep(600)
        if path.exists(RELAIS1_STATUS_DATEI):
            print("Datei {0} existiert.".format(RELAIS1_STATUS_DATEI))
            time.sleep(1)
        else:
            print("Datei {0} existiert nicht.".format(RELAIS1_STATUS_DATEI))
            try:
                with open(LOG_RELAIS1,"a") as r1:
                    r1.write(str((datetime.datetime.now().strftime('\n%Y-%m-%d %H:%M:%S' " Statusdatei für Relais 1 ist verschwunden."))))
            except Exception as error:
                print(error)
            subprocess.run("/home/pi/relais1_aus.py")
            time.sleep(1)
        if path.exists(RELAIS2_STATUS_DATEI):
            print("Datei {0} existiert.".format(RELAIS2_STATUS_DATEI))
            time.sleep(1)
        else:
            print("Datei {0} existiert nicht.".format(RELAIS2_STATUS_DATEI))
            try:
                with open(LOG_RELAIS2,"a") as r2:
                    r2.write(str((datetime.datetime.now().strftime('\n%Y-%m-%d %H:%M:%S' " Statusdatei für Relais 2 ist verschwunden."))))
            except Exception as error:
                print(error)
            subprocess.run("/home/pi/relais2_aus.py")
            time.sleep(1)
        if path.exists(RELAIS3_STATUS_DATEI):
            print("Datei {0} existiert.".format(RELAIS3_STATUS_DATEI))
            time.sleep(1)
        else:
            print("Datei {0} existiert nicht.".format(RELAIS3_STATUS_DATEI))
            try:
                with open(LOG_RELAIS3,"a") as r3:
                    r3.write(str((datetime.datetime.now().strftime('\n%Y-%m-%d %H:%M:%S' " Statusdatei für Relais 3 ist verschwunden."))))
            except Exception as error:
                print(error)
            subprocess.run("/home/pi/relais3_aus.py")
            time.sleep(1)
        if path.exists(RELAIS4_STATUS_DATEI):
            print("Datei {0} existiert.".format(RELAIS4_STATUS_DATEI))
            time.sleep(1)
        else:
            print("Datei {0} existiert nicht.".format(RELAIS4_STATUS_DATEI))
            try:
                with open(LOG_RELAIS4,"a") as r4:
                    r4.write(str((datetime.datetime.now().strftime('\n%Y-%m-%d %H:%M:%S' " Statusdatei für Relais 4 ist verschwunden."))))
            except Exception as error:
                print(error)
            subprocess.run("/home/pi/relais4_aus.py")
            time.sleep(1)
        if path.exists(RELAIS5_STATUS_DATEI):
            print("Datei {0} existiert.".format(RELAIS5_STATUS_DATEI))
            time.sleep(1)
        else:
            print("Datei {0} existiert nicht.".format(RELAIS5_STATUS_DATEI))
            try:
                with open(LOG_RELAIS5,"a") as r5:
                    r5.write(str((datetime.datetime.now().strftime('\n%Y-%m-%d %H:%M:%S' " Statusdatei für Relais 5 ist verschwunden."))))
            except Exception as error:
                print(error)
            subprocess.run("/home/pi/relais5_aus.py")
            time.sleep(1)
        if path.exists(RELAIS6_STATUS_DATEI):
            print("Datei {0} existiert.".format(RELAIS6_STATUS_DATEI))
            time.sleep(1)
        else:
            print("Datei {0} existiert nicht.".format(RELAIS6_STATUS_DATEI))
            try:
                with open(LOG_RELAIS6,"a") as r6:
                    r6.write(str((datetime.datetime.now().strftime('\n%Y-%m-%d %H:%M:%S' " Statusdatei für Relais 6 ist verschwunden."))))
            except Exception as error:
                print(error)
            subprocess.run("/home/pi/relais6_aus.py")
            time.sleep(1)
        if path.exists(RELAIS7_STATUS_DATEI):
            print("Datei {0} existiert.".format(RELAIS7_STATUS_DATEI))
            time.sleep(1)
        else:
            print("Datei {0} existiert nicht.".format(RELAIS7_STATUS_DATEI))
            try:
                with open(LOG_RELAIS7,"a") as r7:
                    r7.write(str((datetime.datetime.now().strftime('\n%Y-%m-%d %H:%M:%S' " Statusdatei für Relais 7 ist verschwunden."))))
            except Exception as error:
                print(error)
            subprocess.run("/home/pi/relais7_aus.py")
            time.sleep(1)
        if path.exists(RELAIS8_STATUS_DATEI):
            print("Datei {0} existiert.".format(RELAIS8_STATUS_DATEI))
            time.sleep(1)
        else:
            print("Datei {0} existiert nicht.".format(RELAIS8_STATUS_DATEI))
            try:
                with open(LOG_RELAIS8,"a") as r8:
                    r8.write(str((datetime.datetime.now().strftime('\n%Y-%m-%d %H:%M:%S' " Statusdatei für Relais 8 ist verschwunden."))))
            except Exception as error:
                print(error)
            subprocess.run("/home/pi/relais8_aus.py")
            time.sleep(1)




if __name__== "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("Abbruch durch Benutzer")
    finally:
        with open(LOG_ENDE, "a") as log:
            log.write(str((datetime.datetime.now().strftime('\n%Y-%m-%d %H:%M:%S' " Programm zur Überwachung der Dateien wurde beendet"))))
