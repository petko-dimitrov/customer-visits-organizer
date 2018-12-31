<?php

namespace CVOBundle\Service\Payment;


class FinanceHolder
{
    /**
     * @var string
     */
    private $annualCashIncome;
    /**
     * @var string
     */
    private $annualBankIncome;
    /**
     * @var string
     */
    private $monthlyCashIncome;
    /**
     * @var string
     */
    private $monthlyBankIncome;
    /**
     * @var string
     */
    private $annualCashExpenses;
    /**
     * @var string
     */
    private $annualBankExpenses;
    /**
     * @var string
     */
    private $monthlyCashExpenses;
    /**
     * @var string
     */
    private $monthlyBankExpenses;


    public function __construct()
    {
        $this->annualCashIncome = '0.00';
        $this->annualBankIncome = '0.00';
        $this->monthlyCashIncome = '0.00';
        $this->monthlyBankIncome = '0.00';
        $this->annualCashExpenses = '0.00';
        $this->annualBankExpenses = '0.00';
        $this->monthlyCashExpenses = '0.00';
        $this->monthlyBankExpenses = '0.00';
    }


    public function getAnnualTotalIncome()
    {
        return number_format(floatval($this->annualBankIncome) + floatval($this->annualCashIncome),
            2, '.', '');
    }

    /**
     * @return string
     */
    public function getAnnualCashIncome()
    {
        return $this->annualCashIncome;
    }

    /**
     * @param string $annualCashIncome
     */
    public function setAnnualCashIncome(string $annualCashIncome)
    {
        $this->annualCashIncome = $annualCashIncome;
    }

    /**
     * @return string
     */
    public function getAnnualBankIncome()
    {
        return $this->annualBankIncome;
    }

    /**
     * @param string $annualBankIncome
     */
    public function setAnnualBankIncome(string $annualBankIncome)
    {
        $this->annualBankIncome = $annualBankIncome;
    }


    public function getMonthlyTotalIncome()
    {
        return number_format(floatval($this->monthlyBankIncome) + floatval($this->monthlyCashIncome),
            2, '.', '');
    }


    /**
     * @return string
     */
    public function getMonthlyCashIncome()
    {
        return $this->monthlyCashIncome;
    }

    /**
     * @param string $monthlyCashIncome
     */
    public function setMonthlyCashIncome(string $monthlyCashIncome)
    {
        $this->monthlyCashIncome = $monthlyCashIncome;
    }

    /**
     * @return string
     */
    public function getMonthlyBankIncome()
    {
        return $this->monthlyBankIncome;
    }

    /**
     * @param string $monthlyBankIncome
     */
    public function setMonthlyBankIncome(string $monthlyBankIncome)
    {
        $this->monthlyBankIncome = $monthlyBankIncome;
    }


    public function getAnnualTotalExpenses()
    {
        return number_format(floatval($this->annualBankExpenses) + floatval($this->annualCashExpenses),
            2, '.', '');
    }


    /**
     * @return string
     */
    public function getAnnualCashExpenses()
    {
        return $this->annualCashExpenses;
    }

    /**
     * @param string $annualCashExpenses
     */
    public function setAnnualCashExpenses(string $annualCashExpenses)
    {
        $this->annualCashExpenses = $annualCashExpenses;
    }

    /**
     * @return string
     */
    public function getAnnualBankExpenses()
    {
        return $this->annualBankExpenses;
    }

    /**
     * @param string $annualBankExpenses
     */
    public function setAnnualBankExpenses(string $annualBankExpenses)
    {
        $this->annualBankExpenses = $annualBankExpenses;
    }


    public function getMonthlyTotalExpenses()
    {
        return number_format(floatval($this->monthlyBankExpenses) + floatval($this->monthlyCashExpenses),
            2, '.', '');
    }


    /**
     * @return string
     */
    public function getMonthlyCashExpenses()
    {
        return $this->monthlyCashExpenses;
    }

    /**
     * @param string $monthlyCashExpenses
     */
    public function setMonthlyCashExpenses(string $monthlyCashExpenses)
    {
        $this->monthlyCashExpenses = $monthlyCashExpenses;
    }

    /**
     * @return string
     */
    public function getMonthlyBankExpenses()
    {
        return $this->monthlyBankExpenses;
    }

    /**
     * @param string $monthlyBankExpenses
     */
    public function setMonthlyBankExpenses(string $monthlyBankExpenses)
    {
        $this->monthlyBankExpenses = $monthlyBankExpenses;
    }
}