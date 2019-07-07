<?php

namespace Blog\Service;

class Mail
{
    /**
     * Send an contact email
     *
     * @param string $message      Message
     * @param string $contactEmail Email
     *
     * @return Mail
     */
    public function sendContact($message, $contactEmail)
    {
        mail(
            'tlarousse3@gmail.com',
            'Nouvelle demande de contact',
            $message,
            'From: ' . $contactEmail
        );
    }
}
