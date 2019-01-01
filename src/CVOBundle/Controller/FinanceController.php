<?php

namespace CVOBundle\Controller;

use CVOBundle\Form\DateType;
use CVOBundle\Service\Payment\FinanceServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FinanceController extends Controller
{
    private $financeService;

    public function __construct(FinanceServiceInterface $paymentService)
    {
        $this->financeService = $paymentService;
    }

    /**
     * @Route("/finances", name="finances")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function financeAction(Request $request)
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

        $financeHolder = $this->financeService->getFinanceInfo($year, $month);

        return $this->render('payment/finances.html.twig', [
            'form' => $form->createView(),
            'financeHolder' => $financeHolder,
            'year' => $year,
            'month' => date("F", strtotime($year . "-" . $month . "-01"))
        ]);
    }
}
