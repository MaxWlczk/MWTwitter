<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\tweet;

class TweetController extends Controller
{
    /**
     * @Route("/", name="app_tweet_list")
     */
    public function listAction(Request $request)
    {
        $tweets = $this->getDoctrine()->getRepository(Tweet::class)->getLastTweets();


        return $this->render(':tweet:list.html.twig', [
            'tweets'=>$tweets,
        ]);
    }
}
