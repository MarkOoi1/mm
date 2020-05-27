<?php

namespace App\Service;

abstract class AbstractScraper
{

    /**
     * @var interval
     */
    protected $interval;

    /**
     * @var url
     */
    protected $url;

    public function __construct()
    {
    }
}
