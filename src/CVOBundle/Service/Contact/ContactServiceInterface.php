<?php

namespace CVOBundle\Service\Contact;


use CVOBundle\Entity\Contact;

interface ContactServiceInterface
{
    public function addContact(Contact $contact, $id);
}