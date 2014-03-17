<?php

namespace Api\Country\Model;

class CountryManager
{

    /**
     * @var \PDO
     */
    private $dbm;

    /**
     * @param \PDO $dbm
     */
    public function __construct(\PDO $dbm)
    {
        $this->dbm = $dbm;
    }

    /**
     * @return array
     */
    public function listAll()
    {
        $listCountries = $this->dbm->query("SELECT id, name, iso FROM countries", \PDO::FETCH_ASSOC);
        return $listCountries->fetchAll();
    }
}
