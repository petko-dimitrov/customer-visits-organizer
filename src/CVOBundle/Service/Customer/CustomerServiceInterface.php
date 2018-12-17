<?php

namespace CVOBundle\Service\Customer;


use CVOBundle\Entity\Customer;

interface CustomerServiceInterface
{
    public function addCustomer(Customer $customer);

    public function editCustomer(Customer $customer);

    public function deleteCustomer(Customer $customer);

    public function checkCustomer($name);

    public function getCustomerById($id);

    public function getAllCustomers();
}