<?php
/**
 * Class ContactController
 *
 * @package Blog\Controller
 *
 * @see \Blog\DoctrineLoader
 */

namespace Blog\Controller;

use Blog\DoctrineLoader;
use Blog\Service\Mail;

/**
 * Class ContactController
 *
 * @package Blog\Controller
 */
class ContactController extends DoctrineLoader
{
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
            Mail::sendContact($data['message'], $data['email']);
            $this->flashMessage->success('Le message à bien été envoyé');
            return $this->redirect('/contact');
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $this->flashMessage->error(self::ERR_GENERIC . $msg);
            return $this->redirect('/contact');
        }
    }
}