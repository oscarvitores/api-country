<?php

namespace Api\Country\Model;

use PDO;
use PHPUnit_Framework_TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-03-12 at 22:40:49.
 */
class CountryManagerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var CountryManager
     */
    protected $sut;

    /**
     *
     * @var PDO
     */
    protected static $dbm;

    /**
     *
     * @var type
     */
    protected static $dataFixtures = array(
        array(1, "España", "ES"),
        array(2, "Francia", "FR"),
    );

    public static function setUpBeforeClass()
    {
        self::$dbm = new PDO('sqlite::memory:');
        self::$dbm->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function tearDownAfterClass()
    {
        self::$dbm = NULL;
    }

    /**
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->sut = new CountryManager(self::$dbm);

        $this->loadFixtures();
    }

    protected function loadFixtures()
    {
        self::$dbm->query('DROP TABLE IF EXISTS countries');

        $ddl = file_get_contents(__DIR__ . "/../../fixtures/database.sql");
        self::$dbm->exec($ddl);

        $insert = self::$dbm->prepare('INSERT INTO countries VALUES (?, ?, ?)');

        foreach (self::$dataFixtures as $country) {
            $insert->execute($country);
        }
    }

    /**
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        self::$dbm->query('DROP TABLE IF EXISTS countries');
    }

    /**
     *
     */
    public function testAccessToAllCountries()
    {
        $result = $this->sut->listAll();

        $rowCount = 0;
        foreach ($result as $value) {
            $rowCount++;
        }

        $dataCount = count(self::$dataFixtures);

        $this->assertEquals($dataCount, $rowCount);

        $result->closeCursor();
    }

    public function testCountriesReadedAreInDataFixturesLoaded()
    {
        $result     = $this->sut->listAll();
        $isRowValid = !empty($result);
        foreach ($result as $key => $value) {
            var_dump($key);
            var_dump($value);
            $isRowValid = $isRowValid && $value['name'] === self::$dataFixtures[$key][1];
        }

        $this->assertTrue($isRowValid);
    }
}
