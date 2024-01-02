#!/usr/bin/env python3
import time
import datetime
import mysql.connector
from mysql.connector import errorcode
import bme280
import smbus2

port = 1
address = 0x76
bus = smbus2.SMBus(port)
calibration_params = bme280.load_calibration_params(bus, address)
data = bme280.sample(bus, address, calibration_params)
#print(data.id)
#print(data.timestamp)
#print(data.temperature)
#print(data.pressure)
#print(data.humidity)

datumzeit=(datetime.datetime.now().strftime('%y-%m-%d %H:%M:%S'))

temperatur=round(data.temperature, 2)
#print(temperatur)

luftdruck=round( data.pressure, 2)
#print(luftdruck)

luftfeuchtigkeit=round(data.humidity, 2)
#print(luftfeuchtigkeit)

db = mysql.connector.connect(user='datenbankbenutzername', password='passwortdesdatenbankbenutzers', host='IPoderHost', database='datenbankname')
cursor = db.cursor(prepared=True)
sql = "INSERT INTO daten (temperatur, luftdruck, luftfeuchtigkeit, datumzeit) VALUES (%s, %s, %s, %s)"
val = (temperatur, luftdruck, luftfeuchtigkeit, datumzeit)
cursor.execute(sql,val)
db.commit()
cursor.close()
db.close()
