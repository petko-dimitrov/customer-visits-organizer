<?php

namespace CVOBundle\Service\Address;


use CVOBundle\Entity\Address;
use CVOBundle\Entity\Customer;
use CVOBundle\Repository\AddressRepository;
use CVOBundle\Repository\CustomerRepository;

class AddressService implements AddressServiceInterface
{
    private $addressRepository;
    private $customerRepository;

    public function __construct(AddressRepository $addressRepository,
                                CustomerRepository $customerRepository)
    {
        $this->addressRepository = $addressRepository;
        $this->customerRepository = $customerRepository;
    }


    public function addAddress(Address $address, $id)
    {
        /** @var Customer $customer */
        $customer = $this->customerRepository->find($id);
        $customer->setAddress($address);
        $this->addressRepository->save($address);
    }
}