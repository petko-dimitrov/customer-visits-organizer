<?php

namespace CVOBundle\Repository;
use CVOBundle\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;

/**
 * ContactRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContactRepository extends \Doctrine\ORM\EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new Mapping\ClassMetadata(Contact::class));
    }

    public function save(Contact $contact)
    {
        $this->_em->persist($contact);
        $this->_em->flush();
    }
}
