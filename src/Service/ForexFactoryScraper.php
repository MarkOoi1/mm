<?php

namespace App\Service;

use App\Entity\Event;
use App\Repository\KeywordsRepository;
use App\Service\AbstractScraper;
use Symfony\Component\HttpClient\HttpClient;

class ForexFactoryScraper extends AbstractScraper
{

    /**
     * @var calList
     */
    private $calList;

    /**
     * @var keywordRep
     */
    private $keywordRep;

    public function __construct(KeywordsRepository $keywordRep)
    {
        $this->calList = [];
        $this->keywordRep = $keywordRep;
    }

    public function getWeeklyCal()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://cdn-nfs.faireconomy.media/ff_calendar_thisweek.json');
        $content = $response->toArray();

        foreach ($content as $val) {
            $calEvent = new Event();
            $date = new \DateTime($val['date']);

            $calEvent->setProfile($val['country']);
            $calEvent->setType("Economy");
            $calEvent->setDate($date);
            $calEvent->setContent($val['title'] . ". Impact: " . $val['impact'] . ", exp: " . $val['forecast'] . ", prev: " . $val['previous']);

            $keyword = $this->keywordRep->findOneBy(["keyword" => $val['country']]);

            if ($keyword) {
                $calEvent->addKeyword($keyword);
                array_push($this->calList, $calEvent);
            }
        }


        return $this->calList;
    }
}
