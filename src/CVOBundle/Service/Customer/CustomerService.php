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

    public function getAllCustomers()
    {
        return $this->customerRepository->findBy(['isActive' => true], ['name' => 'ASC']);
    }

    public function getAllArchivedCustomers()
    {
        return $this->customerRepository->findBy(['isActive' => false], ['name' => 'ASC']);
    }

    public function editCustomer(Customer $customer)
    {
        return $this->customerRepository->edit($customer);
    }


    public function deleteCustomer(Customer $customer)
    {
        return $this->customerRepository->delete($customer);
    }

    public function archiveCustomer(Customer $customer)
    {
        $customer->setIsActive(false);
        return $this->customerRepository->edit($customer);
    }

    public function activateCustomer(Customer $customer)
    {
        $customer->setIsActive(true);
        return $this->customerRepository->edit($customer);
    }
}