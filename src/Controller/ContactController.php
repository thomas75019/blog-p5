<?php

namespace Blog\Controller;

use Blog\Controller\Controller;
use Blog\Dependencies\CrsfToken;
use Blog\Dependencies\Doctrine;
use Blog\Dependencies\FlashMessage;
use Blog\Dependencies\Twig;
use Blog\Service\Mail;
use Blog\Service\UserSession;
class ContactController extends Controller
{
    /**
     * @var string Mail
     */
    private $mail;

    /**
     * ContactController constructor.
     *
     * @param Mail $mail Mailer
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct(Mail $mail)
    {
        $session = new UserSession();
        $twig = new Twig($session);
        $doctrine = new Doctrine();
        $flash = new FlashMessage();
        $token = new CrsfToken();

        parent::__construct($twig, $doctrine, $flash, $token);
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
        $this->render('front/contactPage.html.twig');
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
            $this->flashMessage->success(
                'Le message à bien été envoyé',
                '/contact'
            );
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $this->flashMessage->error(
                self::ERR_GENERIC . $msg,
                '/contact'
            );
        }
    }
}
