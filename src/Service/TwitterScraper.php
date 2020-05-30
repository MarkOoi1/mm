<?php

namespace App\Service;

use App\Entity\Event;
use App\Service\AbstractScraper;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

class TwitterScraper extends AbstractScraper
{
    /**
     * @var profiles
     */
    private $profiles;

    /**
     * @var keywords
     */
    private $keywords;

    /**
     * @var keywordList
     */
    private $keywordList;

    /**
     * @var tweetList
     */
    private $tweetList;


    public function __construct(array $profiles, EntityRepository $keywordsRepository, int $interval)
    {
        $this->profiles = $profiles;
        $this->keywordsRepository = $keywordsRepository;
        $this->interval = strtotime("now") * 1000 - $interval;
        $this->tweetList = [];
        $this->url = "https://twitter.com/";
    }


    public function getTweetsFromInterval()
    {
        if (!is_array($this->profiles)) return null;

        foreach ($this->profiles as $val) {
            $client = HttpClient::create();
            $response = $client->request('GET', 'https://twitter.com/' . $val);
            $content = $response->getContent();

            $crawler = new Crawler($content);
            $crawler->filter('li.stream-item')->each(function (Crawler $node, $i) {

                $tweetName = $node->filter('.fullname')->text();
                $tweetContent = $node->filter('p.tweet-text')->text();
                $tweetDate = $node->filter('.tweet-timestamp > span')->attr('data-time');


                $tweetDateMilliSeconds = $tweetDate * 1000;

                if ($tweetDateMilliSeconds > $this->interval) {    // Convert seconds to milliseconds

                    $date = new \DateTime();

                    $tweet = new Event();
                    $tweet->setProfile($tweetName);
                    $tweet->setType("News");
                    $tweet->setDate($date->setTimestamp($tweetDate));
                    $tweet->setContent($tweetContent);

                    array_push($this->tweetList, $tweet);
                }
            });
        }

        return $this->tweetList;
    }

    public function keywordFilter()
    {
        if (!is_array($this->tweetList)) return null;

        $this->keywordList = $this->keywordsRepository->findAll();

        return array_filter($this->tweetList, function ($val, $key) {

            foreach ($this->keywordList as $keyword) {

                if (strpos($val->getContent(), $keyword->getKeyword()) !== false) {
                    $val->addKeyword($keyword);

                    return $val;
                }
            }
        }, ARRAY_FILTER_USE_BOTH);
    }
}
