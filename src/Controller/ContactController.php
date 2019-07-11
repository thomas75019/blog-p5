<?php

namespace Blog\Controller;

use Blog\Controller\Controller;
use Blog\Dependencies\Doctrine;
use Blog\Dependencies\FlashMessage;
use Blog\Dependencies\Twig;
use Blog\Service\Mail;
use Blog\Service\UserSession;

class ContactController extends Controller
{
    private $mail;

    public function __construct(Mail $mail)
    {
        parent::__construct(new Twig(new UserSession()), new Doctrine(), new FlashMessage());
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
