<?php

namespace Acme\Bundle\DebugBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class Address
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Dude")
     */
    private $dude;

    public function __construct($dude)
    {
        $this->dude = $dude;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDude()
    {
        return $this->dude;
    }
}
