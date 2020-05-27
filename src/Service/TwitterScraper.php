<?php

namespace App\Service;

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
     * @var tweet
     */
    private $tweet;

    /**
     * @var tweetName
     */
    private $tweetName;

    /**
     * @var tweetContent
     */
    private $tweetContent;

    /**
     * @var tweetDate
     */
    private $tweetDate;

    public function __construct(array $profiles, array $keywords)
    {
        $this->profiles = $profiles;
        $this->keywords = $keywords;
    }

    public function getTweets()
    {
        // TODO: Loop through profiles

        $client = HttpClient::create();
        $response = $client->request('GET', 'https://twitter.com/ForexLive');
        $content = $response->getContent();

        $crawler = new Crawler($content);
        $tweet = $crawler->filter('li.stream-item')->each(function (Crawler $node, $i) {
            $tweetName = $node->filter('.fullname')->text();
            $tweetContent = $node->filter('p.tweet-text')->text();
            $tweetDate = $node->filter('.tweet-timestamp > span')->attr('data-time') * 1000; // Convert seconds to milliseconds

        });

        //dump($tweetName);
    }
}
