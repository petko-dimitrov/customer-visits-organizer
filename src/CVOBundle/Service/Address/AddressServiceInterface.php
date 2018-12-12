<?php

namespace CVOBundle\Service\Address;


use CVOBundle\Entity\Address;

interface AddressServiceInterface
{
    public function addAddress(Address $address, $id);
}