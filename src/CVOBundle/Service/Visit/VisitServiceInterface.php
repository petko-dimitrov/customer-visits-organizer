<?php

namespace CVOBundle\Service\Visit;


use CVOBundle\Entity\Visit;

interface VisitServiceInterface
{
    public function addVisit(Visit $visit, $customerId);

    public function getAllForthcoming();

    public function getAllForthcomingByUser($userId);

    public function getAll();

    public function getAllByCustomer($customer);

    public function finishVisit($id);
}