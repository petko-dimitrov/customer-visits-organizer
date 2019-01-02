<?php

namespace CVOBundle\Service\Payment;


interface FinanceServiceInterface
{
    public function getAnnualIncome($year, $paymentType);

    public function getMonthlyIncome($year, $month, $paymentType);

    public function getAnnualExpenses($year, $paymentType);

    public function getMonthlyExpenses($year, $month, $paymentType);

    public function getFinanceInfo($year, $month);
}
