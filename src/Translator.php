<?php

namespace amestsantim\wkt2epsg;

use SQLite3;

class Translator
{
    const PATH_TO_SQLITE_FILE = 'esri/epsg.db';
    private $db;

    public function __construct()
    {
        $this->db = new SQLite3(self::PATH_TO_SQLITE_FILE, SQLITE3_OPEN_READONLY);
    }

    public function wktToEpsg($wkt) {
        $statement = $this->db->prepare('SELECT epsg FROM epsg WHERE wkt = :wkt');
        $statement->bindValue(':wkt', $wkt);
        $result = $statement->execute();
        $resultRow = $result->fetchArray(SQLITE3_ASSOC);
        if ($resultRow) {
            return $resultRow['epsg'];
        }
        return null;
    }

    public function epsgToWkt($epsg) {
        $statement = $this->db->prepare('SELECT wkt FROM epsg WHERE epsg = :epsg');
        $statement->bindValue(':epsg', $epsg);
        $result = $statement->execute();
        $resultRow = $result->fetchArray(SQLITE3_ASSOC);
        if ($resultRow) {
            return $resultRow['wkt'];
        }
        return null;
    }
}
