<?php


namespace App\Listeners;

use Twig\Environment;

class UserRegisteredListener
{
    public $mailer;

    public $_engine;

    public function __construct(\Swift_Mailer $mailer, Environment $engine)
    {
        $this->mailer= $mailer;
        $this->_engine = $engine;
    }

    public function onUserRegistered($event)
    {
        $this->mailer->send( (new \Swift_Message('User Registered'))
            ->setFrom('support@sym.local')
            ->setTo('tunsedres@gmail.com')
            ->setBody($this->_engine->render('emails/registration.html.twig',[
                'name'=>$event->getUser()->getFirstName()
            ]),
                'text/html')
        );
    }

}