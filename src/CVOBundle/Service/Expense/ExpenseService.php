<?php

namespace CVOBundle\Service\Expense;


use CVOBundle\Entity\Expense;
use CVOBundle\Repository\ExpenseRepository;

class ExpenseService implements ExpenseServiceInterface
{
    private $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    public function addExpense(Expense $expense)
    {
        $expense->setDate(new \DateTime());
        $this->expenseRepository->save($expense);
    }

    public function editExpense(Expense $expense)
    {
        $this->expenseRepository->edit($expense);
    }

    public function deleteExpense(Expense $expense)
    {
        $this->expenseRepository->delete($expense);
    }

    public function getExpenses($year, $month)
    {
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $startDate = new \DateTime("$year-$month-01");
        $endDate = new \DateTime("$year-$month-$days");

        return $this->expenseRepository->findExpensesList($startDate, $endDate);
    }

    public function getExpenseById($id)
    {
        return $this->expenseRepository->find($id);
    }
}