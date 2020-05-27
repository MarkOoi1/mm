<?php

namespace App\Service;

use App\Entity\Event;
use App\Service\AbstractScraper;
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
     * @var tweetList
     */
    private $tweetList;


    public function __construct(array $profiles, array $keywords, int $interval)
    {
        $this->profiles = $profiles;
        $this->keywords = $keywords;
        $this->interval = strtotime("now") * 1000 - $interval;
        $this->tweetList = [];
        $this->url = "https://twitter.com/";
    }


    public function getTweetsFromInterval()
    {
        // TODO: Loop through profiles

        $client = HttpClient::create();
        $response = $client->request('GET', 'https://twitter.com/ForexLive');
        $content = $response->getContent();

        $crawler = new Crawler($content);
        $crawler->filter('li.stream-item')->each(function (Crawler $node, $i) {

            $tweetName = $node->filter('.fullname')->text();
            $tweetContent = $node->filter('p.tweet-text')->text();
            $tweetDate = $node->filter('.tweet-timestamp > span')->attr('data-time');

            $tweetDateMilliSeconds = $tweetDate * 1000;

            if ($tweetDateMilliSeconds > $this->interval) {    // Convert seconds to milliseconds

                $tweet = new Event();
                $tweet->setProfile($tweetName);
                $tweet->setType("News");
                $tweet->setDate(new \DateTime('@' . $tweetDate));
                $tweet->setContent($tweetContent);

                array_push($this->tweetList, $tweet);
            }
        });

        return $this->tweetList;
    }

    public function keywordFilter()
    {
        if (!is_array($this->tweetList)) return null;

        return array_filter($this->tweetList, function ($val, $key) {
            foreach ($this->keywords as $keyword) {
                if (strpos($val->getContent(), $keyword)) {
                    return $val;
                }
            }
        }, ARRAY_FILTER_USE_BOTH);
    }
}
