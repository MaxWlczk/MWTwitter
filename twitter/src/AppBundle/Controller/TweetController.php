<?php

namespace AppBundle\Controller;

use AppBundle\Entity\tweet;
use AppBundle\Form\tweetType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TweetController extends Controller
{
    private function getManager()
    {
        return $this->container->get('app.tweet_manager');
    }

    private function getMessenger()
    {
        return $this->container->get('app.email_messenger');
    }

    /**
     * @Route("/", name="app_tweet_list")
     */
    public function listAction(Request $request)
    {
        $tweetManager = $this->getManager();
        $tweets = $tweetManager->getLast();

        return $this->render(':tweet:list.html.twig', [
            'tweets' => $tweets,
        ]);
    }

    /**
     * @Route("/tweet/new", name="app_tweet_new", methods={"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $tweetManager = $this->getManager();
        $newTweet = $tweetManager->create();
        $form = $this->createForm(tweetType::class, $newTweet); // retourne un objet Form

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // formulaire valide
            // on modifie la base de données
            $tweetManager->save($newTweet);
            $this->addFlash(
                'success',
              'votre tweet a été créé'
            );
            $emailManager = $this->getMessenger();
            $emailManager->sendTweetCreated($newTweet);
            // On redirige vers la page de visualisation du tweet nouvellement créée
            return $this->redirectToRoute('app_tweet_view', ['id' => $newTweet->getId()]);
        }

        return $this->render(':tweet:new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tweet/{id}", name="app_tweet_view")
     */
    public function viewAction(Tweet $tweet)
    {
        return $this->render(':tweet:view.html.twig', [
                'tweet' => $tweet,
            ]);
    }
}
