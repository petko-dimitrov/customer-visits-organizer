<?php

namespace CVOBundle\Service\Contact;

use CVOBundle\Entity\Contact;
use CVOBundle\Entity\Customer;
use CVOBundle\Repository\ContactRepository;
use CVOBundle\Repository\CustomerRepository;

class ContactService implements ContactServiceInterface
{
    private $contactRepository;
    private $customerRepository;

    public function __construct(ContactRepository $contactRepository,
                                CustomerRepository $customerRepository)
    {
        $this->contactRepository = $contactRepository;
        $this->customerRepository = $customerRepository;
    }

    public function addContact(Contact $contact, $id)
    {
        /** @var Customer $customer */
        $customer = $this->customerRepository->find($id);
        $customer->addContact($contact);

        $contact->setCustomer($customer);
        $this->contactRepository->save($contact);
    }

    public function editContact(Contact $contact)
    {
        $this->contactRepository->edit($contact);
    }

    public function deleteContact(Contact $contact)
    {
        $this->contactRepository->delete($contact);
    }

    public function getContactById($id)
    {
        return $this->contactRepository->find($id);
    }
}