<?php

namespace CVOBundle\Service\Visit;


use CVOBundle\Entity\Visit;

interface VisitServiceInterface
{
    public function addVisit(Visit $visit, $customerId);
}