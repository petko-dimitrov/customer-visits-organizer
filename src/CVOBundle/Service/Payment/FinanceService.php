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

    public function getAnnualCashExpenses($year)
    {
        $startDate = new \DateTime("$year-01-01");
        $endDate = new \DateTime("$year-12-31");

        return $this->expenseRepository->findExpensesSum($startDate, $endDate, 'cash');
    }

    public function getAnnualBankExpenses($year)
    {
        $startDate = new \DateTime("$year-01-01");
        $endDate = new \DateTime("$year-12-31");

        return $this->expenseRepository->findExpensesSum($startDate, $endDate, 'bank');
    }

    public function getMonthlyCashExpenses($year, $month)
    {
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $startDate = new \DateTime("$year-$month-01");
        $endDate = new \DateTime("$year-$month-$days");

        return $this->expenseRepository->findExpensesSum($startDate, $endDate, 'cash');
    }

    public function getMonthlyBankExpenses($year, $month)
    {
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $startDate = new \DateTime("$year-$month-01");
        $endDate = new \DateTime("$year-$month-$days");

        return $this->expenseRepository->findExpensesSum($startDate, $endDate, 'bank');
    }

    public function getFinanceInfo($year, $month)
    {
        $annualCashIncome = $this->getAnnualCashIncome($year)[0]['result'];
        $annualBankIncome = $this->getAnnualBankIncome($year)[0]['result'];
        $monthlyCashIncome = $this->getMonthlyCashIncome($year, $month)[0]['result'];
        $monthlyBankIncome = $this->getMonthlyBankIncome($year, $month)[0]['result'];

        $annualCashExpenses = $this->getAnnualCashExpenses($year)[0]['result'];
        $annualBankExpenses = $this->getAnnualBankExpenses($year)[0]['result'];
        $monthlyCashExpenses = $this->getMonthlyCashExpenses($year, $month)[0]['result'];
        $monthlyBankExpenses = $this->getMonthlyBankExpenses($year, $month)[0]['result'];

        $annualCashIncome ? $this->financeHolder->setAnnualCashIncome($annualCashIncome)
            : $this->financeHolder->setAnnualCashIncome('0.00');
        $annualBankIncome ? $this->financeHolder->setAnnualBankIncome($annualBankIncome)
            : $this->financeHolder->setAnnualBankIncome('0.00');
        $monthlyCashIncome ? $this->financeHolder->setMonthlyCashIncome($monthlyCashIncome)
            : $this->financeHolder->setMonthlyCashIncome('0.00');
        $monthlyBankIncome ? $this->financeHolder->setMonthlyBankIncome($monthlyBankIncome)
            : $this->financeHolder->setMonthlyBankIncome('0.00');

        $annualCashExpenses ? $this->financeHolder->setAnnualCashExpenses($annualCashExpenses)
            : $this->financeHolder->setAnnualCashExpenses('0.00');
        $annualBankExpenses ? $this->financeHolder->setAnnualBankExpenses($annualBankExpenses)
            : $this->financeHolder->setAnnualBankExpenses('0.00');
        $monthlyCashExpenses ? $this->financeHolder->setMonthlyCashExpenses($monthlyCashExpenses)
            : $this->financeHolder->setMonthlyCashExpenses('0.00');
        $monthlyBankExpenses ? $this->financeHolder->setMonthlyBankExpenses($monthlyBankExpenses)
            : $this->financeHolder->setMonthlyBankExpenses('0.00');

        return $this->financeHolder;
    }
}