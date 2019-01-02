<?php

namespace CVOBundle\Service\Payment;


interface FinanceServiceInterface
{
    public function getAnnualCashIncome($year);

    public function getAnnualBankIncome($year);

    public function getMonthlyCashIncome($year, $month);

    public function getMonthlyBankIncome($year, $month);

    public function getAnnualCashExpenses($year);

    public function getAnnualBankExpenses($year);

    public function getMonthlyCashExpenses($year, $month);

    public function getMonthlyBankExpenses($year, $month);

    public function getFinanceInfo($year, $month);
}
