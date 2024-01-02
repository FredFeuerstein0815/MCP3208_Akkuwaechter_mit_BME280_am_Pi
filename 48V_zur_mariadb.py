#!/usr/bin/env python3

import time
import datetime
import mysql.connector
from mysql.connector import errorcode

SPANNUNG = "/dev/shm/mcp3208_ch6.txt"

def main():
    datumzeit=(datetime.datetime.now().strftime('%y-%m-%d %H:%M:%S'))
    try:
        with open(SPANNUNG, "r") as v:
            spannung = v.read()
            db = mysql.connector.connect(user='datenbankbenutzername', password='geheim', host='IPoderHost', database='spannung48volt')
            cursor = db.cursor(prepared=True)
            sql = "INSERT INTO daten (spannung, datumzeit) VALUES (%s, %s)"
            val = (spannung, datumzeit)
            cursor.execute(sql,val)
            db.commit()
            cursor.close()
            db.close()
    except Exception as error:
        print(error)

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("Abbruch durch Benutzer\n")
    finally:
        print("Bye bye")
