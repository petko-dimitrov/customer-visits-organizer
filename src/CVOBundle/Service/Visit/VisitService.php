<?php

namespace CVOBundle\Service\Visit;


use CVOBundle\Entity\Customer;
use CVOBundle\Entity\Visit;
use CVOBundle\Repository\CustomerRepository;
use CVOBundle\Repository\VisitRepository;
use DateInterval;

class VisitService implements VisitServiceInterface
{
    private $visitRepository;
    private $customerRepository;

    public function __construct(VisitRepository $visitRepository,
                                CustomerRepository $customerRepository)
    {
        $this->visitRepository = $visitRepository;
        $this->customerRepository = $customerRepository;
    }

    public function addVisit(Visit $visit, $customerId)
    {
        /** @var Customer $customer */
        $customer = $this->customerRepository->find($customerId);
        $customer->addVisit($visit);

        $visit->setIsFinished(false);
        $visit->setCustomer($customer);

        $this->visitRepository->save($visit);
    }

    public function getAll()
    {
        return $this->visitRepository->findBy([], ['date' => 'ASC']);
    }

    public function getAllVisits($year, $month, $isFinished)
    {
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $startDate = new \DateTime("$year-$month-01");
        $endDate = new \DateTime("$year-$month-$days");

        return $this->visitRepository->findVisits($startDate, $endDate, $isFinished);
    }

    public function getAllByCustomer($customer, $year, $isFinished)
    {
        $startDate = new \DateTime("$year-01-01");
        $endDate = new \DateTime("$year-12-31");

        return $this->visitRepository->findVisitsByCustomer($customer, $startDate, $endDate, $isFinished);
    }

    public function getAllByUser($userId, $year, $month, $isFinished)
    {
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $startDate = new \DateTime("$year-$month-01");
        $endDate = new \DateTime("$year-$month-$days");

        return $this->visitRepository->findVisitsByUser($userId, $startDate, $endDate, $isFinished);
    }

    public function getVisitById($id)
    {
        return $this->visitRepository->find($id);
    }

    public function editVisit(Visit $visit)
    {
        $users = $visit->getUsers();

        foreach ($users as $user) {
           $visit->addUser($user);
           $user->addVisit($visit);
        }

        return $this->visitRepository->edit($visit);
    }

    public function deleteVisit(Visit $visit)
    {
        return $this->visitRepository->delete($visit);
    }

    public function finishVisit($id)
    {
        /** @var Visit $visit */
        $visit = $this->visitRepository->find($id);
        $visit->setIsFinished(true);

        $this->visitRepository->edit($visit);
    }

    public function scheduleVisit(Visit $visit)
    {
        $customer = $visit->getCustomer();
        $users = $visit->getUsers();

        /** @var Visit $nextVisit */
        $nextVisit = new Visit();
        $nextVisit->setTaxCollected($visit->getTaxCollected());
        $nextVisit->setTime($visit->getTime());
        $nextVisit->setIsFinished(false);
        $nextVisit->setServiceType($visit->getServiceType());
        $nextVisit->setMoreInfo($visit->getMoreInfo());
        $nextVisit->setIsFinished(false);
        $nextVisit->setIsRegular(true);
        $nextVisit->setCustomer($customer);
        $nextVisit->setDate($visit->getDate());
        $nextVisit->setPaymentType($visit->getPaymentType());

        foreach ($users as $user) {
            $nextVisit->addUser($user);
            $user->addVisit($nextVisit);
        }

        $currentMonth = intval($nextVisit->getDate()->format('m'));
        $nextVisit->getDate()->add(new DateInterval('P1M'));
        $nextMonth = intval($nextVisit->getDate()->format('m'));

        //check month
        if ($nextMonth - $currentMonth !== 1) {
            $nextVisit->getDate()->sub(new DateInterval('P3D'));
        }

        //check if weekend
        $dayOfWeek = $nextVisit->getDate()->format('l');
        $day = intval($nextVisit->getDate()->format('j'));

        if ($dayOfWeek === 'Saturday' || $dayOfWeek === 'Sunday') {
            if ($day <= 26) {
                $nextVisit->getDate()->add(new DateInterval('P2D'));
            } else {
                $nextVisit->getDate()->sub(new DateInterval('P2D'));
            }
        }

        $customer->addVisit($nextVisit);

        $this->visitRepository->save($nextVisit);
    }

    public function deleteVisitUsers($visitId)
    {
        $this->visitRepository->deleteUsers($visitId);
    }

}