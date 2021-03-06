#! /usr/bin/env python
# -*- coding: utf-8 -*-

# Gter copyleft 2020
# Author: Roberto Marzocchi
# Script che interroga il DB MS-SQL con i dati degli idrometri comunali:


import os, sys, re  # ,shutil,glob

import getopt  # per gestire gli input

import pymssql
import conn_mssql as c

import psycopg2
import conn as p



def main():
    
    con = psycopg2.connect(host=p.ip, dbname=p.db, user=p.user, password=p.pwd, port=p.port)
    cur = con.cursor()
    con.autocommit = True

    conn = pymssql.connect(server=c.server, user=c.user, password=c.password, database=c.database)
    cursor = conn.cursor()
    # query='SELECT id_manufatto, civico FROM VManufatti where codvia = 33760;'
    # query="SELECT ID_Manufatto, codvia FROM VIndirizziManufatti where codvia =33760 and civico='0104' and colore = 'R' and lettera is null;"
    query0 = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE';"
    cursor.execute(query0)
    id_aste = cursor.fetchall()
    # print("Print each row and it's columns values")
    for row in id_aste:
    #    #id = row[0]
        print(len(row))
        # 4
        print('{}, {}, {}, {}'.format(row[0],row[1],row[2],row[3]))
    query1 = "SELECT TOP 15  m.IDtime, AVG(m.value) as value, m.quality, s.IDStation,s.station FROM DATA m JOIN TAGS t ON m.IDtag=t.IDtag JOIN STATIONS s ON s.IDstation = t.IDstation where t.IDMea=9 and m.quality=0 GROUP BY m.quality, s.IDStation,s.station, m.IDtime ORDER BY m.IDtime desc;"
    #query1 = "SELECT s.IDStation,s.station, max(t.first_rec), max(t.last_rec), t.input_name FROM stations s JOIN TAGS t ON s.IDstation = t.IDstation where t.IDMea=9  and s.station not like '% ID%' GROUP BY s.IDStation,s.station, t.input_name;"
    #query1 = "SELECT * FROM TAGS;"
    #query1="SELECT COLUMN_NAME,* FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'DATA'"
    #query1= "SELECT * FROM STATIONS";
    #query1="SELECT TOP 15 d.IDtime, d.value, t.Idstation, d.iDtag, t.rec_time FROM DATA d JOIN TAGS t ON d.IDtag=t.IDtag where t.IDMea=9 ORDER BY IDtime DESC";
    print('#####################################################################################')
    print(query1)
    print('#####################################################################################')
    cursor.execute(query1)
    #row = cursor.fetchone()
    #while row:
    #    print("ID={}, Name={}".format(row[0], row[1]))
    #    row = cursor.fetchone
    id_aste = cursor.fetchall()
    print(len(id_aste))
    # print("Print each row and it's columns values")
    i=0
    for row in id_aste:
    #    #id = row[0]
        if i==0:
            print(len(row))
        i+=1
        # 2
        #print('{}, {}'.format(row[0],row[1]))
        # 4
        #print('{}, {}, {}, {}'.format(row[0],row[1],row[2],row[3]))
        # 5 
        print('{}, {}, {}, {}, {}'.format(row[0],row[1],row[2],row[3], row[4]))
        query2="INSERT INTO geodb.lettura_idrometri_comune (id_station, data_ora, lettura) VALUES ('{0}',TO_TIMESTAMP('{1}', 'YYYYMMDDHH24MISS'), {2});".format(row[3],row[0],round(row[1],2))
        print(query2)
        try:
            cur.execute(query2);
        except:
            print('Dato delle {0} non inserito'.format(row[0]))
        # 13
        #print('{}, {}, {}, {}, {},{}, {}, {}, {}, {},{}, {}, {}'.format(row[0],row[1],row[2],row[3], row[4],row[5],row[6],row[7],row[8], row[9],row[10],row[11],row[12]))
        
    #exit()
    # print("id_asta={}".format(id_asta))

    conn.close()
    con.close()


if __name__ == "__main__":
    main()
