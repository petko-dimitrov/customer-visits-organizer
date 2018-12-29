<?php

namespace CVOBundle\Service\Visit;


use CVOBundle\Entity\Visit;

interface VisitServiceInterface
{
    public function addVisit(Visit $visit, $customerId);

    public function getAllForthcoming();

    public function getAllForthcomingByUser($userId);

    public function getAllFinished();

    public function getAll();

    public function getAllByCustomer($customer);

    public function getForthcomingByCustomer($customer);

    public function finishVisit($id);

    public function getVisitById($id);

    public function editVisit(Visit $visit);

    public function deleteVisit(Visit $visit);

    public function scheduleVisit(Visit $visit);

    public function deleteVisitUsers($visitId);
}