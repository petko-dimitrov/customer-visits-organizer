<?php

namespace CVOBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Customer
 *
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="CVOBundle\Repository\CustomerRepository")
 */
class Customer
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
     *      minMessage = "Customer name must be at least {{ limit }} characters long",
     *      maxMessage = "Customer name cannot be longer than {{ limit }} characters"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @Assert\GreaterThan(0,
     *     message = "The monthly tax must be a positive number."
     * )
     * @var string
     *
     * @ORM\Column(name="monthly_tax", type="decimal", precision=10, scale=2)
     */
    private $monthlyTax;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @Assert\GreaterThanOrEqual("today",
     *     message = "The next visit must be today or in the future."
     * )
     *
     * @var \DateTime
     *
     * @ORM\Column(name="next_visit", type="date", nullable=true)
     */
    private $nextVisit;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="more_info", type="text", nullable=true)
     */
    private $moreInfo;


    /**
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Email cannot be longer than {{ limit }} characters"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Email cannot be longer than {{ limit }} characters"
     * )
     *
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     *
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Website cannot be longer than {{ limit }} characters"
     * )
     *
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     *
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var Address
     *
     * @ORM\OneToOne(targetEntity="CVOBundle\Entity\Address")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     */
    private $address;

    /**
     * @var ArrayCollection|Visit[]
     *
     * @ORM\OneToMany(targetEntity="CVOBundle\Entity\Visit", mappedBy="customer")
     */
    private $visits;

    /**
     * @var ArrayCollection|Contact[]
     *
     * @ORM\OneToMany(targetEntity="CVOBundle\Entity\Contact", mappedBy="customer")
     */
    private $contacts;

    public function __construct()
    {
        $this->visits = new ArrayCollection();
        $this->contacts = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Customer
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
     * Set monthlyTax
     *
     * @param string $monthlyTax
     *
     * @return Customer
     */
    public function setMonthlyTax($monthlyTax)
    {
        $this->monthlyTax = $monthlyTax;

        return $this;
    }

    /**
     * Get monthlyTax
     *
     * @return string
     */
    public function getMonthlyTax()
    {
        return $this->monthlyTax;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Customer
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set nextVisit
     *
     * @param \DateTime $nextVisit
     *
     * @return Customer
     */
    public function setNextVisit($nextVisit)
    {
        $this->nextVisit = $nextVisit;

        return $this;
    }

    /**
     * Get nextVisit
     *
     * @return \DateTime
     */
    public function getNextVisit()
    {
        return $this->nextVisit;
    }

    /**
     * Set moreInfo
     *
     * @param string $moreInfo
     *
     * @return Customer
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
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }



    /**
     * Set email
     *
     * @param string $email
     *
     * @return Customer
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
     * Set website
     *
     * @param string $website
     *
     * @return Customer
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @return Visit[]|ArrayCollection
     */
    public function getVisits()
    {
        return $this->visits;
    }

    /**
     * @param Visit $visit
     */
    public function addVisit(Visit $visit)
    {
        $this->visits[] = $visit;
    }

    /**
     * @return Contact[]|ArrayCollection
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param Contact $contact
     */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;
    }
}

