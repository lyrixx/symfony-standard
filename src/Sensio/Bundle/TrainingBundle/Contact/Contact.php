<?php

namespace Sensio\Bundle\TrainingBundle\Contact;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    public $sender;

    /**
     * @Assert\NotBlank
     */
    public $subject;

    /**
     * @Assert\NotBlank
     */
    public $message;
}
