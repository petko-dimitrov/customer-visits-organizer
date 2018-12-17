<?php

namespace CVOBundle\Service\Contact;


use CVOBundle\Entity\Contact;

interface ContactServiceInterface
{
    public function addContact(Contact $contact, $id);

    public function editContact(Contact $contact);

    public function deleteContact(Contact $contact);

    public function getContactById($id);
}