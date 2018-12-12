<?php

namespace CVOBundle\Service\Customer;


use CVOBundle\Entity\Customer;

interface CustomerServiceInterface
{
    public function addCustomer(Customer $customer);

    public function checkCustomer($name);

    public function getCustomerById($id);

    public function getAllCustomers();
}