<?php
/**
 * Created by PhpStorm.
 * User: thomaslarousse
 * Date: 05/07/2019
 * Time: 18:57
 */

namespace Blog\Controller;


use Blog\DoctrineLoader;
use Blog\Service\Mail;

class ContactController extends DoctrineLoader
{
    /**
     * Render contact view
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function contactPage()
    {
        echo $this->twig->render('forms/contact.html.twig');
    }

    /**
     * @param $data array
     */
    public function contactSend($data)
    {
        try {
            Mail::sendContact($data['message'], $data['email']);
            $this->flashMessage->success('Le message à bien été envoyé');
            return $this->redirect('/contact');
        } catch (\Exception $exception)
        {
            $this->flashMessage->error('Une erreur est apparu' . $exception->getCode());
            return $this->redirect('/contact');
        }
    }

}