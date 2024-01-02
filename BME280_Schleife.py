#!/usr/bin/env python3

import smbus
import time
import datetime
import subprocess
from ctypes import c_short
from ctypes import c_byte
from ctypes import c_ubyte

DEVICE = 0x76  # Standard-Geräteaddresse am I2C
BUS = smbus.SMBus(1)


def get_short(data, index):
    return c_short((data[index+1] << 8) + data[index]).value


def get_ushort(data, index):
    return (data[index+1] << 8) + data[index]


def get_char(data, index):
    result = data[index]
    if result > 127:
        result -= 256
    return result


def get_uchar(data, index):
    result = data[index] & 0xFF
    return result


def read_bme280id(addr=DEVICE):
    reg_id = 0xD0
    (chip_id, chip_version) = BUS.read_i2c_block_data(addr, reg_id, 2)
    return chip_id, chip_version


def read_bme280_all(addr=DEVICE):
    reg_data = 0xF7
    reg_control = 0xF4
    reg_config = 0xF5
    reg_control_hum = 0xF2
    reg_hum_msb = 0xFD
    reg_hum_lsb = 0xFE
    oversample_temp = 2
    oversample_pres = 2
    mode = 1
    oversample_hum = 2
    BUS.write_byte_data(addr, reg_control_hum, oversample_hum)
    control = oversample_temp << 5 | oversample_pres << 2 | mode
    BUS.write_byte_data(addr, reg_control, control)
    cal1 = BUS.read_i2c_block_data(addr, 0x88, 24)
    cal2 = BUS.read_i2c_block_data(addr, 0xA1, 1)
    cal3 = BUS.read_i2c_block_data(addr, 0xE1, 7)
    dig_t1 = get_ushort(cal1, 0)
    dig_t2 = get_short(cal1, 2)
    dig_t3 = get_short(cal1, 4)
    dig_p1 = get_ushort(cal1, 6)
    dig_p2 = get_short(cal1, 8)
    dig_p3 = get_short(cal1, 10)
    dig_p4 = get_short(cal1, 12)
    dig_p5 = get_short(cal1, 14)
    dig_p6 = get_short(cal1, 16)
    dig_p7 = get_short(cal1, 18)
    dig_p8 = get_short(cal1, 20)
    dig_p9 = get_short(cal1, 22)
    dig_h1 = get_uchar(cal2, 0)
    dig_h2 = get_short(cal3, 0)
    dig_h3 = get_uchar(cal3, 2)
    dig_h4 = get_char(cal3, 3)
    dig_h4 = (dig_h4 << 24) >> 20
    dig_h4 = dig_h4 | (get_char(cal3, 4) & 0x0F)
    dig_h5 = get_char(cal3, 5)
    dig_h5 = (dig_h5 << 24) >> 20
    dig_h5 = dig_h5 | (get_uchar(cal3, 4) >> 4 & 0x0F)
    dig_h6 = get_char(cal3, 6)
    wait_time = 1.25 + (2.3 * oversample_temp) + ((2.3 * oversample_pres) + 0.575) + ((2.3 * oversample_hum)+0.575)
    time.sleep(wait_time/1000)
    data = BUS.read_i2c_block_data(addr, reg_data, 8)
    pres_raw = (data[0] << 12) | (data[1] << 4) | (data[2] >> 4)
    temp_raw = (data[3] << 12) | (data[4] << 4) | (data[5] >> 4)
    hum_raw = (data[6] << 8) | data[7]
    var1 = ((((temp_raw>>3)-(dig_t1<<1)))*(dig_t2)) >> 11
    var2 = (((((temp_raw >> 4) - dig_t1) * ((temp_raw >> 4) - dig_t1)) >> 12) * dig_t3) >> 14
    t_fine = var1+var2
    temperature = float(((t_fine * 5) + 128) >> 8)
    var1 = t_fine / 2.0 - 64000.0
    var2 = var1 * var1 * dig_p6 / 32768.0
    var2 = var2 + var1 * dig_p5 * 2.0
    var2 = var2 / 4.0 + dig_p4 * 65536.0
    var1 = (dig_p3 * var1 * var1 / 524288.0 + dig_p2 * var1) / 524288.0
    var1 = (1.0 + var1 / 32768.0) * dig_p1
    if var1 == 0:
        pressure = 0
    else:
        pressure = 1048576.0 - pres_raw
        pressure = ((pressure - var2 / 4096.0) * 6250.0) / var1
        var1 = dig_p9 * pressure * pressure / 2147483648.0
        var2 = pressure * dig_p8 / 32768.0
        pressure = pressure + (var1 + var2 + dig_p7) / 16.0
    humidity = t_fine - 76800.0
    humidity = (hum_raw - (dig_h4 * 64.0 + dig_h5 / 16384.0 * humidity)) * \
               (dig_h2 / 65536.0 * (1.0 + dig_h6 / 67108864.0 * humidity * (1.0 + dig_h3 / 67108864.0 * humidity)))
    humidity = humidity * (1.0 - dig_h1 * humidity / 524288.0)
    if humidity > 100:
        humidity = 100
    elif humidity < 0:
        humidity = 0
    return temperature/100.0, pressure/100.0, humidity


def main():
    while True:
        subprocess.run("/usr/bin/clear")
        with open("/home/pi/intervall_bme280.txt", "r") as intervalldatei:
            intervall = int(intervalldatei.read())
            print("Ausleseintervall beträgt {0} Sekunden" .format(intervall))
        (chip_id, chip_version) = read_bme280id()
#        print("Chip ID     :", chip_id)
#        print("Version     :", chip_version)
        temperature, pressure, humidity = read_bme280_all()
        print(datetime.datetime.now().strftime('%y-%m-%d %H:%M:%S'))
        print("Temperatur : ", temperature, "°C")
        print("Luftdruck : {:.2f}".format(pressure), "hPa")
        print("Luftfeuchtigkeit : {:.2f}".format(humidity), "%")
        with open("/dev/shm/temperatur.txt", "w") as t:
            t.write(str("{0:.2f}".format(temperature)))
        with open("/dev/shm/luftdruck.txt", "w") as p:
            p.write(str("{0:.2f}".format(pressure)))
        with open("/dev/shm/luftfeuchtigkeit.txt", "w") as f:
            f.write(str("{0:.2f}".format(humidity)))
        time.sleep(intervall)
if __name__ == "__main__":
    main()
