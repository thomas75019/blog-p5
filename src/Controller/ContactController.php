<?php
/**
 * Created by PhpStorm.
 * User: thomaslarousse
 * Date: 05/07/2019
 * Time: 18:57
 */

namespace Blog\Controller;


use Blog\DoctrineLoader;

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
     * @return mixed
     */
    public function contactSend($data)
    {
        return Mail::sendContact($data['message'], $data['email']);
    }

}