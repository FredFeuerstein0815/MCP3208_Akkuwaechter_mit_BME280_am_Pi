#!/usr/bin/env python3

from MCP3208 import MCP3208

def main():
    adc = MCP3208()
    value = adc.read( channel = 0 )
    print(value)
    print("Anliegende Spannung an Kanal 0: %.2f Volt" % (value / 1231) )
    try:
        with open("/dev/shm/mcp3208_ch0.txt", "w") as v:
            v.write(str("{0:.2f}".format(value / 1231)))
    except Exception as error:
        print(error)

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("Abbruch durch Benutzer")
    finally:
        print("Bye bye")
