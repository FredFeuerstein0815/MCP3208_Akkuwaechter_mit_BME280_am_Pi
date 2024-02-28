#!/usr/bin/env python3

from MCP3208 import MCP3208
from RPi import GPIO as gpio
import time
import datetime

adc = MCP3208()
INTERVALL_DATEI = "/home/pi/intervall_mcp3208_ch7.txt"
EINSCHALTSPANNUNG = "/home/pi/einschaltspannung_ch7_12V.txt"
AUSSCHALTSPANNUNG = "/home/pi/ausschaltspannung_ch7_12V.txt"
SPANNUNG = "/dev/shm/mcp3208_ch7.txt"
AN_AUS_DATEI = "/pfad/zu/daten/strom_an_aus/zerow_an_aus_ch7_12V.txt"
RELAIS1_PIN = 18
RELAIS2_PIN = 23
RELAIS_1_STATUS_DATEI = "/dev/shm/relais1_status.txt"
RELAIS_2_STATUS_DATEI = "/dev/shm/relais2_status.txt"
gpio.setmode(gpio.BCM)
gpio.setup(RELAIS1_PIN, gpio.OUT, initial=gpio.HIGH)
gpio.setup(RELAIS2_PIN, gpio.OUT, initial=gpio.HIGH)

def relais_aus():
    gpio.setmode(gpio.BCM)
    gpio.output([RELAIS1_PIN], True)
    gpio.output([RELAIS2_PIN], True)
    with open(RELAIS_1_STATUS_DATEI, "w") as r1:
        r1.write('1')
    with open(RELAIS_2_STATUS_DATEI, "w") as r2:
        r2.write('1')

def relais_an():
    gpio.setmode(gpio.BCM)
    gpio.output([RELAIS1_PIN], False)
    gpio.output([RELAIS2_PIN], False)
    with open(RELAIS_1_STATUS_DATEI, "w") as r1:
        r1.write('2')
    with open(RELAIS_2_STATUS_DATEI, "w") as r2:
        r2.write('2')

def main():
    relais_aus()
    try:
        with open(AN_AUS_DATEI, "a") as aus:
            aus.write(str((datetime.datetime.now().strftime('\n%Y-%m-%d %H:%M:%S' " Strom aus bei Programmstart"))))
            print("\nStrom aus bei Programmstart\n")
    except Exception as error:
        print(error)
    while True:
        with open(INTERVALL_DATEI, "r") as intervalldatei:
            intervall = int(intervalldatei.read())
            print("Ausleseintervall beträgt {0} Sekunden\n" .format(intervall))
        with open(AUSSCHALTSPANNUNG, "r") as ausschaltspannungsdatei:
            ausschaltspannung = float(ausschaltspannungsdatei.read())
            print("Ausschaltspannung beträgt {0} Volt\n" .format(ausschaltspannung))
        with open(EINSCHALTSPANNUNG, "r") as einschaltspannungsdatei:
            einschaltspannung = float(einschaltspannungsdatei.read())
            print("Einschaltspannung beträgt {0} Volt\n" .format(einschaltspannung))
        print(str((datetime.datetime.now().strftime('\n%Y-%m-%d %H:%M:%S' " Uhr\n"))))
        value = adc.read( channel = 7 )
        print("Ausgelesener Wert: \n", value)
        print("Anliegende Spannung: %.2f Volt\n" % (value / 264.07) )
        with open(SPANNUNG, "w") as v:
            v.write(str("{0:.2f}".format(value / 264.07)))
        spannung = float((value / 264.07))
        if spannung >= einschaltspannung and gpio.input(RELAIS1_PIN) == gpio.LOW and gpio.input(RELAIS2_PIN) == gpio.LOW:
            print("Spannung {0:.2f} über {1} Volt Einschaltspannung, Strom ist an, bleibt an.\n".format(spannung, einschaltspannung))
            print("Prüfe in {} Sekunden nochmal.\n".format(intervall))
            time.sleep(intervall)
        elif spannung <= einschaltspannung and ausschaltspannung <= spannung and gpio.input(RELAIS1_PIN) == gpio.LOW and gpio.input(RELAIS2_PIN) == gpio.LOW:
            print("Spannung {0:.2f} unter {1} Volt Einschaltspannung, aber über Ausschaltspannung, Strom ist an, bleibt an.\n".format(spannung, einschaltspannung))
            print("Prüfe in {} Sekunden nochmal.\n".format(intervall))
            time.sleep(intervall)
        elif spannung <= ausschaltspannung and gpio.input(RELAIS1_PIN) == gpio.LOW and gpio.input(RELAIS2_PIN) == gpio.LOW:
            print("Spannung {0:.2f} unter {1} Volt Ausschaltspannung, Strom ist an, schalte aus.\n".format(spannung, ausschaltspannung))
            relais_aus()
            try:
                with open(AN_AUS_DATEI, "a") as aus:
                    aus.write(str((datetime.datetime.now().strftime('\n%Y-%m-%d %H:%M:%S' " Strom aus bei {:.2f} Volt".format(spannung)))))
            except Exception as error:
                print(error)
            time.sleep(intervall)
        elif spannung >= ausschaltspannung and spannung <= einschaltspannung and gpio.input(RELAIS1_PIN) == gpio.HIGH and gpio.input(RELAIS2_PIN) == gpio.HIGH:
            print("Spannung {0:.2f} >= {1} Volt Ausschaltspannung, aber kleiner als Einschaltspannung von {2} Volt, Strom ist aus, bleibt aus.\n".format(spannung, ausschaltspannung, einschaltspannung))
            time.sleep(intervall)
        elif spannung <= ausschaltspannung and spannung <= einschaltspannung and gpio.input(RELAIS1_PIN) == gpio.HIGH and gpio.input(RELAIS2_PIN) == gpio.HIGH:
            print("Spannung {0:.2f} unter {1} Volt Ausschaltspannung und unter {2} Einschaltspannung, Strom ist aus, bleibt aus.\n".format(spannung, ausschaltspannung, einschaltspannung))
            time.sleep(intervall)
        elif spannung >= einschaltspannung and gpio.input(RELAIS1_PIN) == gpio.HIGH and gpio.input(RELAIS2_PIN) == gpio.HIGH:
            print("Spannung {0:.2f} über {1} Volt Einschaltspannung, Strom ist aus, schalte jetzt an.\n".format(spannung, einschaltspannung))
            relais_an()
            try:
                with open(AN_AUS_DATEI, "a") as an:
                    an.write(str((datetime.datetime.now().strftime('\n%Y-%m-%d %H:%M:%S' " Strom an bei {:.2f} Volt".format(spannung)))))
            except Exception as error:
                print(error)
            time.sleep(intervall)
        else:
            print("Fehler beim Zugriff auf GPIOs !")
            relais_aus()
            time.sleep(intervall)

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("Abbruch durch Benutzer. \n Schalte Relais 1 und 2 aus.")
    finally:
        gpio.output([RELAIS1_PIN], True)
        gpio.output([RELAIS2_PIN], True)
        with open(RELAIS_1_STATUS_DATEI, "w") as r1:
            r1.write('1')
        with open(RELAIS_2_STATUS_DATEI, "w") as r2:
            r2.write('1')
            with open(AN_AUS_DATEI, "a") as aus:
                aus.write(str((datetime.datetime.now().strftime('\n%Y-%m-%d %H:%M:%S' " Strom aus bei Programmende"))))

          
