<?php

namespace CVOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Address
 *
 * @ORM\Table(name="addressеs")
 * @ORM\Entity(repositoryClass="CVOBundle\Repository\AddressRepository")
 */
class Address
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\Length(
     *      min = 1,
     *      max = 255,
     *      minMessage = "Town name must be at least {{ limit }} characters long",
     *      maxMessage = "Town name cannot be longer than {{ limit }} characters"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255)
     */
    private $town;

    /**
     * @Assert\Length(
     *      min = 1,
     *      max = 255,
     *      minMessage = "Street name must be at least {{ limit }} characters long",
     *      maxMessage = "Street name cannot be longer than {{ limit }} characters"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Street number cannot be longer than {{ limit }} characters"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255, nullable=true)
     */
    private $number;

    /**
     * @Assert\GreaterThanOrEqual(0,
     *     message = "Floor cannot be a negative number."
     * )
     *
     * @var int
     *
     * @ORM\Column(name="floor", type="integer", nullable=true)
     */
    private $floor;

    /**
     * @var int
     *
     * @ORM\Column(name="apartment", type="integer", nullable=true)
     */
    private $apartment;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set town
     *
     * @param string $town
     *
     * @return Address
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Address
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set floor
     *
     * @param integer $floor
     *
     * @return Address
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * Get floor
     *
     * @return int
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Set appartment
     *
     * @param integer $apartment
     *
     * @return Address
     */
    public function setApartment($apartment)
    {
        $this->apartment = $apartment;

        return $this;
    }

    /**
     * Get appartment
     *
     * @return int
     */
    public function getApartment()
    {
        return $this->apartment;
    }
}

