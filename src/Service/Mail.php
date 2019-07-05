<?php
/**
 * Created by PhpStorm.
 * User: thomaslarousse
 * Date: 05/07/2019
 * Time: 19:13
 */

namespace Blog\Service;


class Mail
{
    public static function sendContact($message, $contactEmail)
    {
        mail('tlarousse3@gmail.com', 'Nouvelle demande de contact', $message,
            'From: ' . $contactEmail);
    }

}