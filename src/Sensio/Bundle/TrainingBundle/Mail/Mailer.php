<?php

namespace Sensio\Bundle\TrainingBundle\Mail;

use Sensio\Bundle\TrainingBundle\Contact\Contact;
use Symfony\Bundle\TwigBundle\TwigEngine;

class Mailer
{
    private $mailer;
    private $twig;
    private $recipient;

    public function __construct(\Swift_Mailer $mailer, TwigEngine $twig, $recipient = 'lyrixx@lyrixx.info')
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->recipient = $recipient;
    }

    public function sendContactMail(Contact $contact)
    {
        $body = $this->twig->render('SensioTrainingBundle:Contact:email.html.twig', array('contact' => $contact));

        $message = \Swift_Message::newInstance()
            ->setTo($this->recipient)
            ->setFrom($contact->sender)
            ->setSubject($contact->subject)
            ->setBody($body, 'text/html')
        ;

        return $this->mailer->send($message);
    }
}
