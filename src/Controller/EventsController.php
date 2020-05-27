<?php

namespace App\Controller;

use App\Entity\Keywords;
use App\Entity\Event;
use App\Repository\EventRepository;
use App\Repository\KeywordsRepository;
use App\Service\TwitterScraper;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\EventRegistry;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/events", name="events")
 */

class EventsController extends AbstractController
{
    /**
     * @var keywordList
     */
    private $keywordList;

    /**
     * @var logger
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/twitter", name="twitter")
     */
    public function twitter(EventRepository $eventRep, KeywordsRepository $keywordRep)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $profiles = ["ForexLive", "LiveSquawk"];
        $this->keywordList = $keywordRep->getKeywordsArray();

        foreach ($profiles as $val) {
            $url = "https://twitter.com/" . $val;

            $newNewsItems = [];
        }

        $latestTweets = new TwitterScraper($profiles, $this->keywordList, 120000000);
        $latestTweets->getTweetsFromInterval();
        $filteredTweets = $latestTweets->keywordFilter();

        if (is_array($filteredTweets)) {
            foreach ($filteredTweets as $val) {
                $dbcheck = $eventRep->findOneBy(array("date" => $val->getDate(), "profile" =>  $val->getProfile()));

                if ((bool) $dbcheck) {
                    $this->logger->info("item already saved.");
                } else {
                    $entityManager->persist($val);
                    $this->logger->info("saved item");
                }
            }

            $entityManager->flush();

            return $this->json("Events found. Check log for details");
        }


        return $this->json("No new Events");
    }
}
