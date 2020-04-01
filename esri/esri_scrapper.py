import requests
from bs4 import BeautifulSoup, SoupStrainer
import sqlite3
import pandas as pd

class EsriWktEpsgScrapeToSqlite:
    def __init__(self, url, db, table):
        self.url = url
        self.db = db
        self.table = table
        self.conn = sqlite3.connect(self.db)

    def scrape_esri(self):
        only_tr_tags = SoupStrainer('tr')
        trs = BeautifulSoup(requests.get(self.url).content, 'html.parser', parse_only = only_tr_tags)
        #URL = 'esri.html'
        #trs = BeautifulSoup(open(URL).read(), 'html.parser', parse_only = only_tr_tags)
        wkt_defs = []
        epsg_codes = []
        names = []
        for tr in trs:
            tds = tr.find_all('td')
            if len(tds) > 0:
                if len(tds) == 1:
                    wkt = tds[0].contents[0]
                    wkt_defs.append(wkt)
                    #print(wkt, end='\n\n')
                elif len(tds) == 2:
                    epsg = tds[0].a['id']
                    epsg_codes.append(epsg)
                    name = tds[1].string
                    names.append(name)
                    # print(epsg, end='\n')
                    # print(name, end='\n\n')
        return pd.DataFrame(list(zip(epsg_codes, names, wkt_defs)), columns =['epsg', 'name', 'wkt'])

    def write_data(self, df):
        df.to_sql(self.table, con = self.conn, if_exists = 'replace', index = False)

url = 'https://developers.arcgis.com/javascript/3/jshelp/pcs.html'
scrapper = EsriWktEpsgScrapeToSqlite(url, 'epsg.db', 'epsg')
df = scrapper.scrape_esri()
print(df)
scrapper.write_data(df)
