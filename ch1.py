#!/usr/bin/env python3

from MCP3208 import MCP3208

def main():
    adc = MCP3208()
    value = adc.read( channel = 1 )
    print(value)
    print("Anliegende Spannung an Kanal 1: %.2f Volt" % (value / 747) )
    try:
        with open("/dev/shm/mcp3208_ch1.txt", "w") as v:
            v.write(str("{0:.2f}".format(value / 747)))
    except Exception as error:
        print(error)

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("Abbruch durch Benutzer")
    finally:
        print("Bye bye")
