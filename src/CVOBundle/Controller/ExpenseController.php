<?php

namespace CVOBundle\Controller;

use CVOBundle\Entity\Expense;
use CVOBundle\Form\DateType;
use CVOBundle\Form\ExpenseType;
use CVOBundle\Service\Expense\ExpenseServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("expense")
 * Class ExpenseController
 * @package CVOBundle\Controller
 */
class ExpenseController extends Controller
{
    private $expenseService;

    public function __construct(ExpenseServiceInterface $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    /**
     * @Route("/add", name="add_expense")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $expense = new Expense();

        $form = $this->createForm(ExpenseType::class, $expense);
        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($expense);

        if (count($errors) > 0) {
            return $this->render('expense/add_expense.html.twig', array(
                'form' => $form->createView(),
                'errors' => $errors,
                'expense' => $expense
            ));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->expenseService->addExpense($expense);
            $this->addFlash('message', "Expense added successfully!");

            return $this->redirectToRoute('list_expenses');
        }

        return $this->render('expense/add_expense.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors,
            'expense' => $expense
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit_expense")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $expense = $this->expenseService->getExpenseById($id);

        if ($expense == null) {
            $this->redirectToRoute('list_expenses');
        }

        $form = $this->createForm(ExpenseType::class, $expense);
        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($expense);

        if (count($errors) > 0) {
            return $this->render('expense/add_expense.html.twig', array(
                'form' => $form->createView(),
                'errors' => $errors,
                'expense' => $expense
            ));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->expenseService->editExpense($expense);

            $this->addFlash('message', $expense->getName() . " edited successfully!");
            return $this->redirectToRoute('list_expenses');
        }

        return $this->render('expense/add_expense.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors,
            'expense' => $expense
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_expense")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $expense = $this->expenseService->getExpenseById($id);

        if ($expense == null) {
            $this->redirectToRoute('list_expenses');
        }

        $this->expenseService->deleteExpense($expense);

        $this->addFlash('message', $expense->getName() . " deleted successfully!");
        return $this->redirectToRoute('list_expenses');
    }


    /**
     * @Route("/list", name="list_expenses")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $form = $this->createForm(DateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $year = $data['year'];
            $month = $data['month'];
        } else {
            $date = new \DateTime();
            $year = $date->format('Y');
            $month = $date->format('m');
        }

        $expenses = $this->expenseService->getExpenses($year, $month);

        return $this->render('expense/list.html.twig', [
            'form' => $form->createView(),
            'expenses' => $expenses,
            'year' => $year,
            'month' => date("F", strtotime($year . "-" . $month . "-01"))
        ]);
    }
}
