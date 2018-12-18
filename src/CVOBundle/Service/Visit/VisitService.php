<?php

namespace CVOBundle\Service\Visit;


use CVOBundle\Entity\Customer;
use CVOBundle\Entity\Visit;
use CVOBundle\Repository\CustomerRepository;
use CVOBundle\Repository\VisitRepository;

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
        $customer->setNextVisit($visit->getDate());

        $visit->setIsFinished(false);
        $visit->setCustomer($customer);

        $this->visitRepository->save($visit);
    }

    public function getAllForthcoming()
    {
        return $this->visitRepository->findForthcoming();
    }

    public function finishVisit($id)
    {
        /** @var Visit $visit */
        $visit = $this->visitRepository->find($id);
        $visit->setIsFinished(true);

        $this->visitRepository->save($visit);
    }

    public function getAll()
    {
        return $this->visitRepository->findBy([], ['date' => 'ASC']);
    }

    public function getAllForthcomingByUser($userId)
    {
        return $this->visitRepository->findForthcomingByUser($userId);
    }

    public function getAllByCustomer($customer)
    {
        return $this->visitRepository->findBy(['customer' => $customer], ['date' => 'DESC']);
    }

    public function getVisitById($id)
    {
        return $this->visitRepository->find($id);
    }

    public function editVisit(Visit $visit)
    {
        return $this->visitRepository->edit($visit);
    }

    public function deleteVisit(Visit $visit)
    {
        return $this->visitRepository->delete($visit);
    }
}