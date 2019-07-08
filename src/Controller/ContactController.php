<?php

namespace Blog\Controller;

use Blog\DoctrineLoader;
use Blog\Service\Mail;

class ContactController extends DoctrineLoader
{
    private $mail;

    public function __construct(Mail $mail)
    {
        parent::__construct();
        $this->mail = $mail;
    }

    /**
     * Render contact view
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function contactPage()
    {
        echo $this->twig->render('forms/contact.html.twig');
    }

    /**
     * Send the email
     *
     * @param array $data Datas
     *
     * @return void
     *
     * @throws \Exception
     */
    public function contactSend($data)
    {
        try {
            $this->mail->sendSmtp($data['message'], $data['email']);
            $this->flashMessage->success('Le message à bien été envoyé');
            return $this->redirect('/contact');
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $this->flashMessage->error(self::ERR_GENERIC . $msg);
            return $this->redirect('/contact');
        }
    }
}
