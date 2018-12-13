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

        $visit->setCustomer($customer);


        $this->visitRepository->save($visit);
    }
}