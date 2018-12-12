<?php

namespace CVOBundle\Service\Customer;


use CVOBundle\Entity\Customer;
use CVOBundle\Repository\CustomerRepository;

class CustomerService implements CustomerServiceInterface
{
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function addCustomer(Customer $customer)
    {
        $customer->setIsActive(true);
        $this->customerRepository->save($customer);
    }

    public function checkCustomer($name)
    {
        return $this->customerRepository->findBy(['name' => $name]);
    }

    public function getCustomerById($id)
    {
        return $this->customerRepository->find($id);
    }
}