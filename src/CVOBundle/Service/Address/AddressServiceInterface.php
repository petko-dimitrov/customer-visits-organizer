<?php

namespace CVOBundle\Service\Address;


use CVOBundle\Entity\Address;

interface AddressServiceInterface
{
    public function addAddress(Address $address, $id);

    public function editAddress(Address $address);

    public function deleteAddress(Address $address);

    public function getAddressById($id);
}