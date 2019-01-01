<?php

namespace CVOBundle\Service\Visit;


use CVOBundle\Entity\Visit;

interface VisitServiceInterface
{
    public function addVisit(Visit $visit, $customerId);

    public function getAll();

    public function getVisitById($id);

    public function getAllVisits($year, $month, $isFinished);

    public function getAllByUser($userId, $year, $month, $isFinished);

    public function getAllByCustomer($customer, $year, $isFinished);

    public function finishVisit($id);

    public function editVisit(Visit $visit);

    public function deleteVisit(Visit $visit);

    public function scheduleVisit(Visit $visit);

    public function deleteVisitUsers($visitId);
}