<?php

namespace Sensio\Bundle\TrainingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Dude
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sensio\Bundle\TrainingBundle\Entity\DudeRepository")
 * @UniqueEntity(fields={"email"}, message="This email already exists")
 */
class Dude
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @assert\NotBlank()
     * @assert\Length(max=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @assert\NotBlank()
     * @assert\Length(min=2, max=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @assert\NotBlank()
     * @assert\Email()
     * @assert\Length(max=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     * @assert\NotBlank()
     * @assert\Country()
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=255)
     * @assert\NotBlank()
     * @assert\Language()
     */
    private $language;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Address",
     *     mappedBy="dude",
     *     cascade={"persist", "remove"}
     *
     * )
     * @Assert\Valid()
     */
    private $addresses;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }

    /**
     * @Assert\True(message="Your password should not contain your name")
     */
    public function isPasswordValid()
    {
        return false === strpos($this->password, $this->name);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Dude
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Dude
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Dude
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return Dude
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Dude
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Add addresses
     *
     * @param Address $address
     * @return Dude
     */
    public function addAddresse(Address $address)
    {
        $address->setDude($this);
        $this->addresses[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param Address $address
     */
    public function removeAddresse(Address $address)
    {
        $this->address->removeElement($address);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }
}
