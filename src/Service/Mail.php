<?php

namespace Blog\Service;

/**
 * Class Mail
 * @package Blog\Service
 */
class Mail
{
    /**
     * Send an contact email
     *
     * @param string  $message
     * @param string  $contactEmail
     */
    public static function sendContact($message, $contactEmail)
    {
        mail(
            'tlarousse3@gmail.com',
            'Nouvelle demande de contact',
            $message,
            'From: ' . $contactEmail
        );
    }
}
