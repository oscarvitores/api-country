<?php

namespace Api\Country;

class CountryManager
{

    private $dba;

    /**
     *
     * @param \PDO $dba
     */
    public function __construct(\PDO $dba)
    {
        $this->dba = $dba;
    }
}
