<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 10/03/2017
 * Time: 12:01.
 */

namespace AppBundle\Messenger;

use AppBundle\Entity\tweet;
use Swift_Mailer;

class EmailMessenger
{
    private $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendTweetCreated(tweet $tweet)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Nouveau tweet')
            ->setFrom('send.from@mail.net')
            ->setTo('send.to@mail.net')
            ->setBody($tweet->getMessage());

        $this->mailer->send($message);
    }
}
