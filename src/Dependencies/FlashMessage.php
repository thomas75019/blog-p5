<?php
/**
 * Instantiate anf get flash message for dependency injection
 */
namespace Blog\Dependencies;

use Plasticbrain\FlashMessages\FlashMessages;

class FlashMessage
{

    /**
     * @var FlashMessages Object FlashMessage
     */
    public $flash;

    /**
     * FlashMessage constructor.
     */
    public function __construct()
    {
        $this->flash = new FlashMessages();
    }

    /**
     * @return FlashMessages
     */
    public function getFlash()
    {
        return $this->flash;
    }
}
