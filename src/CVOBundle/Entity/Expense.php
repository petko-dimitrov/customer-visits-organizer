<?php

namespace CVOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Expense
 *
 * @ORM\Table(name="expenses")
 * @ORM\Entity(repositoryClass="CVOBundle\Repository\ExpenseRepository")
 */
class Expense
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
     *      max = 255,
     *      maxMessage = "Expense name cannot be longer than {{ limit }} characters"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     *
     * @Assert\GreaterThan(0,
     *     message = "Quantity must be a positive number."
     * )
     *
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     *
     * @Assert\GreaterThan(0,
     *     message = "Price must be a positive number."
     * )
     *
     * @var string
     *
     * @ORM\Column(name="single_price", type="decimal", precision=10, scale=2)
     */
    private $singlePrice;

    /**
     * @Assert\GreaterThan(0,
     *     message = "Price must be a positive number."
     * )
     *
     * @var string
     *
     * @ORM\Column(name="total_price", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $totalPrice;

    /**
     * @Assert\Length(
     *      max = 55,
     *      maxMessage = "Payment type cannot be longer than {{ limit }} characters"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="payment_type", type="string", length=55)
     */
    private $paymentType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;


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
     * Set name
     *
     * @param string $name
     *
     * @return Expense
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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Expense
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set singlePrice
     *
     * @param string $singlePrice
     *
     * @return Expense
     */
    public function setSinglePrice($singlePrice)
    {
        $this->singlePrice = $singlePrice;

        return $this;
    }

    /**
     * Get singlePrice
     *
     * @return string
     */
    public function getSinglePrice()
    {
        return $this->singlePrice;
    }

    /**
     * Set totalPrice
     *
     * @param string $totalPrice
     *
     * @return Expense
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return string
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return Expense
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     * @return Expense
     */
    public function setPaymentType(string $paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }
}

