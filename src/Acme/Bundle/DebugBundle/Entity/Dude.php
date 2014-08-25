<?php

namespace Acme\Bundle\DebugBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class Dude
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Address", cascade="all")
     */
    private $deliveryAddress;

    /**
     * @ORM\OneToOne(targetEntity="Address", cascade="all")
     */
    private $billingAddress;

    public function getId()
    {
        return $this->id;
    }

    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress($deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;
    }

    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }
}
