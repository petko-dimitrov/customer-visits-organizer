<?php

namespace CVOBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Visit
 *
 * @ORM\Table(name="visits")
 * @ORM\Entity(repositoryClass="CVOBundle\Repository\VisitRepository")
 */
class Visit
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
     * @var string
     *
     * @ORM\Column(name="tax_collected", type="decimal", precision=10, scale=2)
     */
    private $taxCollected;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_regular", type="boolean")
     */
    private $isRegular;

    /**
     * @var string
     *
     * @ORM\Column(name="service_type", type="string", length=255, nullable=true)
     */
    private $serviceType;

    /**
     * @var string
     *
     * @ORM\Column(name="more_info", type="text", nullable=true)
     */
    private $moreInfo;

    /**
     * @var ArrayCollection|User[]
     *
     * @ORM\ManyToMany(targetEntity="CVOBundle\Entity\User", mappedBy="visits")
     */
    private $users;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="CVOBundle\Entity\Customer", inversedBy="visits")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;


    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

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
     * Set taxCollected
     *
     * @param string $taxCollected
     *
     * @return Visit
     */
    public function setTaxCollected($taxCollected)
    {
        $this->taxCollected = $taxCollected;

        return $this;
    }

    /**
     * Get taxCollected
     *
     * @return string
     */
    public function getTaxCollected()
    {
        return $this->taxCollected;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Visit
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set isRegular
     *
     * @param boolean $isRegular
     *
     * @return Visit
     */
    public function setIsRegular($isRegular)
    {
        $this->isRegular = $isRegular;

        return $this;
    }

    /**
     * Get isRegular
     *
     * @return bool
     */
    public function getIsRegular()
    {
        return $this->isRegular;
    }

    /**
     * Set serviceType
     *
     * @param string $serviceType
     *
     * @return Visit
     */
    public function setServiceType($serviceType)
    {
        $this->serviceType = $serviceType;

        return $this;
    }

    /**
     * Get serviceType
     *
     * @return string
     */
    public function getServiceType()
    {
        return $this->serviceType;
    }

    /**
     * Set moreInfo
     *
     * @param string $moreInfo
     *
     * @return Visit
     */
    public function setMoreInfo($moreInfo)
    {
        $this->moreInfo = $moreInfo;

        return $this;
    }

    /**
     * Get moreInfo
     *
     * @return string
     */
    public function getMoreInfo()
    {
        return $this->moreInfo;
    }

    /**
     * @return User[]|ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param $user
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
    }
}

