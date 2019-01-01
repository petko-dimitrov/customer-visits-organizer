<?php

namespace CVOBundle\Service\Expense;


use CVOBundle\Entity\Expense;

interface ExpenseServiceInterface
{
    public function addExpense(Expense $expense);

    public function editExpense(Expense $expense);

    public function deleteExpense(Expense $expense);

    public function getExpenses($year, $month);

    public function getExpenseById($id);
}