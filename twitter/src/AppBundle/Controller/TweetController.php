<?php

namespace AppBundle\Controller;

use AppBundle\Entity\tweet;
use AppBundle\Form\tweetType;
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
     * @Route("/tweet/new", name="app_tweet_new", methods={"GET", "POST"})
     */
    public function addAction(Request $request){
        $tweet = new tweet();
        $form = $this->createForm(tweetType::class, $tweet); // retourne un objet Form

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // formulaire valide
            // on modifie la base de données
            $em = $this->getDoctrine()->getManager();
            $em->persist($tweet);
            $em->flush();

            $this->addFlash(
                "success",
              "votre tweet a été créé"
            );
            // On redirige vers la page de visualisation du tweet nouvellement créée
            return $this->redirectToRoute('app_tweet_view', array("id" => $tweet->getId()));
        }
        return $this->render(':tweet:new.html.twig', array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/tweet/{id}", name="app_tweet_view")
     */
    public function viewAction(Tweet $tweet){

            return $this->render(':tweet:view.html.twig', [
                'tweet' => $tweet,
            ]);
    }


}
