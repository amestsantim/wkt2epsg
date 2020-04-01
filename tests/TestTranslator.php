<?php

require_once __DIR__ . '/../vendor/autoload.php';

use amestsantim\wkt2epsg\Translator;

class TestTranslator extends PHPUnit_Framework_TestCase
{
    private $testCases;
    private $translator;

    protected function setUp()
    {
        parent::setUp();
        $this->testCases = [
            [
                'wkt' => 'PROJCS["Pampa_del_Castillo_Argentina_2",GEOGCS["GCS_Pampa_del_Castillo",DATUM["D_Pampa_del_Castillo",SPHEROID["International_1924",6378388.0,297.0]],PRIMEM["Greenwich",0.0],UNIT["Degree",0.0174532925199433]],PROJECTION["Transverse_Mercator"],PARAMETER["False_Easting",2500000.0],PARAMETER["False_Northing",0.0],PARAMETER["Central_Meridian",-69.0],PARAMETER["Scale_Factor",1.0],PARAMETER["Latitude_Of_Origin",-90.0],UNIT["Meter",1.0]]',
                'epsg' => 2082
            ],
            [
                'wkt' => 'PROJCS["WGS_1984_Web_Mercator_Auxiliary_Sphere",GEOGCS["GCS_WGS_1984",DATUM["D_WGS_1984",SPHEROID["WGS_1984",6378137.0,298.257223563]],PRIMEM["Greenwich",0.0],UNIT["Degree",0.0174532925199433]],PROJECTION["Mercator_Auxiliary_Sphere"],PARAMETER["False_Easting",0.0],PARAMETER["False_Northing",0.0],PARAMETER["Central_Meridian",0.0],PARAMETER["Standard_Parallel_1",0.0],PARAMETER["Auxiliary_Sphere_Type",0.0],UNIT["Meter",1.0]]',
                'epsg' => 3857
            ]
        ];
        $this->translator = new Translator();
    }

    public function testCanFindEpsgCodeForGivenWkt()
    {
        $this->assertEquals($this->testCases[0]['epsg'], $this->translator->wktToEpsg($this->testCases[0]['wkt']));
        $this->assertEquals(null, $this->translator->wktToEpsg('garbage text in place of proper wkt'));
    }

    public function testCanFindWktForGivenEpsgCode()
    {
        $this->assertEquals($this->testCases[1]['wkt'], $this->translator->epsgToWkt($this->testCases[1]['epsg']));
        $this->assertEquals(null, $this->translator->epsgToWkt(9));
    }
}
