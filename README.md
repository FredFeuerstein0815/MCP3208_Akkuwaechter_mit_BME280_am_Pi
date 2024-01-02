# MCP3208_Akkuwaechter_mit_BME280_am_Pi
In diesem Projekt geht es um das auslesen eines MCP3208, eines BME280, der Überwachung von Akkus und um das schalten von Relais.\
Dargestellt werden die Daten mittels Apache2 und Grafana.

Vorraussetzungen Hardware:\
Raspberry Pi\
8-fach-Relaisboard\
MCP3208\
BME280\
Widerstände\
Der MCP3208 wird mit den 3,3 Volt des Pi versorgt, deshalb benötigt man für Spannungen über 3,3 Volt an den Kanälen einen Spannungsteiler.

Vorraussetzungen Software:\
Apache2\
MariaDB

![alt text](https://github.com/FredFeuerstein0815/MCP3208_Akkuwaechter_mit_BME280_am_Pi/blob/main/Screenshot_Pi_Zero.jpg)
![alt text](https://github.com/FredFeuerstein0815/MCP3208_Akkuwaechter_mit_BME280_am_Pi/blob/main/akkuspannung_grafana.png)
![alt text](https://github.com/FredFeuerstein0815/MCP3208_Akkuwaechter_mit_BME280_am_Pi/blob/main/pi_mit_mcp3208_und_relaisboard.webp)
