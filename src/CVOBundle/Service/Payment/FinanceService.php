<?php

namespace CVOBundle\Service\Payment;


use CVOBundle\Repository\ExpenseRepository;
use CVOBundle\Repository\VisitRepository;

class FinanceService implements FinanceServiceInterface
{
    private $visitRepository;
    private $expenseRepository;
    private $financeHolder;

    public function __construct(VisitRepository $visitRepository,
                                ExpenseRepository $expenseRepository, FinanceHolder $financeHolder)
    {
        $this->visitRepository = $visitRepository;
        $this->expenseRepository = $expenseRepository;
        $this->financeHolder = $financeHolder;
    }


    public function getAnnualCashIncome($year)
    {
        $startDate = new \DateTime("$year-01-01");
        $endDate = new \DateTime("$year-12-31");

        return $this->visitRepository->findIncome($startDate, $endDate, 'cash');
    }

    public function getAnnualBankIncome($year)
    {
        $startDate = new \DateTime("$year-01-01");
        $endDate = new \DateTime("$year-12-31");

        return $this->visitRepository->findIncome($startDate, $endDate, 'bank');
    }

    public function getMonthlyCashIncome($year, $month)
    {
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $startDate = new \DateTime("$year-$month-01");
        $endDate = new \DateTime("$year-$month-$days");

        return $this->visitRepository->findIncome($startDate, $endDate, 'cash');
    }

    public function getMonthlyBankIncome($year, $month)
    {
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $startDate = new \DateTime("$year-$month-01");
        $endDate = new \DateTime("$year-$month-$days");

        return $this->visitRepository->findIncome($startDate, $endDate, 'bank');
    }

    public function getFinanceInfo($year, $month)
    {
        $annualCashIncome = $this->getAnnualCashIncome($year)[0]['result'];
        $annualBankIncome = $this->getAnnualBankIncome($year)[0]['result'];
        $monthlyCashIncome = $this->getMonthlyCashIncome($year, $month)[0]['result'];
        $monthlyBankIncome = $this->getMonthlyBankIncome($year, $month)[0]['result'];

        $annualCashIncome ? $this->financeHolder->setAnnualCashIncome($annualCashIncome)
            : $this->financeHolder->setAnnualCashIncome('0.00');
        $annualBankIncome ? $this->financeHolder->setAnnualBankIncome($annualBankIncome)
            : $this->financeHolder->setAnnualBankIncome('0.00');
        $monthlyCashIncome ? $this->financeHolder->setMonthlyCashIncome($monthlyCashIncome)
            : $this->financeHolder->setMonthlyCashIncome('0.00');
        $monthlyBankIncome ? $this->financeHolder->setMonthlyBankIncome($monthlyBankIncome)
            : $this->financeHolder->setMonthlyBankIncome('0.00');

        return $this->financeHolder;
    }
}