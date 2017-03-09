<?php

namespace AppBundle\Controller;

use AppBundle\Entity\tweet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TweetController extends Controller
{
    /**
     * @Route("/", name="app_tweet_list")
     */
    public function listAction(Request $request)
    {
        $tweets = $this->getDoctrine()->getRepository(Tweet::class)->getLastTweets($this->getParameter('app_tweet_nb_last', 10));

        return $this->render(':tweet:list.html.twig', [
            'tweets' => $tweets,
        ]);
    }


    /**
     * @Route("/tweet/{id}", name="app_tweet_view")
     */
    public function viewAction($id){

        $tweet = $this->getDoctrine()->getRepository(Tweet::class)->getTweet($id);

        if($tweet){
            return $this->render(':tweet:view.html.twig', [
                'tweet' => $tweet,
            ]);
        }else{
            throw new NotFoundHttpException("Page not found");
        }

    }
}
