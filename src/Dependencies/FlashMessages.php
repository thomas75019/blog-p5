<?php

namespace Blog\Dependencies;

use Plasticbrain\FlashMessages\FlashMessages;

/**
 * Class FlashMessage
 *
 * Set Up flashMessages
 *
 * @package Blog\Dependencies
 */
class FlashMessage
{
    /**
     * @var FlashMessages
     */
    public $flashMessage;

    /**
     * FlashMessage constructor.
     */
    public function __construct()
    {
        $this->flashMessage = new FlashMessages();

        if(isset($_SESSION['flash_messages']))
        {
            $this->flashMessage->display();
        }
    }

    /**
     * @return FlashMessages
     */
    public function getFlashMessage()
    {
        return $this->flashMessage;
    }
}