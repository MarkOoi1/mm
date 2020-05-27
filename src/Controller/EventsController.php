<?php

namespace App\Controller;

use App\Entity\Keywords;
use App\Repository\KeywordsRepository;
use App\Service\TwitterScraper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    /**
     * @var keywordList
     */
    private $keywordList;

    /**
     * @Route("/events", name="events")
     */
    public function index(EntityManagerInterface $entityManager)
    {

        $profiles = ["ForexLive", "LiveSquawk"];
        $this->keywordList = $entityManager->getRepository(Keywords::class)->getAllSelNameArr();

        foreach ($profiles as $val) {
            $url = "https://twitter.com/" . $val;

            $newNewsItems = [];
        }

        $test = new TwitterScraper($profiles, $this->keywordList);
        dump($test->getTweets());
        die;


        return $this->json("test");
    }
}
