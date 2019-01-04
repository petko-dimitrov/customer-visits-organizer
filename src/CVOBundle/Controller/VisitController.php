<?php

namespace CVOBundle\Controller;


use CVOBundle\Entity\Customer;
use CVOBundle\Entity\Visit;
use CVOBundle\Form\DateType;
use CVOBundle\Form\VisitType;
use CVOBundle\Form\YearType;
use CVOBundle\Service\Customer\CustomerServiceInterface;
use CVOBundle\Service\User\UserServiceInterface;
use CVOBundle\Service\Visit\VisitServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("visit")
 * Class VisitController
 * @package CVOBundle\Controller
 */
class VisitController extends Controller
{
    private $visitService;
    private $customerService;
    private $userService;

    public function __construct(VisitServiceInterface $visitService,
                                CustomerServiceInterface $customerService, UserServiceInterface $userService)
    {
        $this->visitService = $visitService;
        $this->customerService = $customerService;
        $this->userService = $userService;
    }


    /**
     * @Route("/add/{id}", name="add_visit")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, $id)
    {
        $customer = $this->customerService->getCustomerById($id);
        $visit = new Visit();
        $visitForm = $this->createForm(VisitType::class, $visit);

        $visitForm->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($visit);

        if (count($errors) > 0) {
            return $this->render('visit/add_visit.html.twig', array(
                'form' => $visitForm->createView(),
                'id' => $id,
                'errors' => $errors,
                'customer' => $customer,
                'visit' => $visit
            ));
        }

        if ($visitForm->isSubmitted() && $visitForm->isValid()) {
            $users = $visit->getUsers();

            foreach ($users as $user) {
                $user->addVisit($visit);
            }

            $this->visitService->addVisit($visit, $id);

            $this->addFlash('message', "Visit to " . $customer->getName() . " added successfully!");
            return $this->redirectToRoute('all_customers');
        }

        return $this->render('visit/add_visit.html.twig', array(
                'form' => $visitForm->createView(),
                'id' => $id,
                'errors' => $errors,
                'customer' => $customer,
                'visit' => $visit
            ));
    }

    /**
     * @Route("/edit/{id}", name="edit_visit")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        /** @var Visit $visit */
        $visit = $this->visitService->getVisitById($id);

        $customer = $visit->getCustomer();

        if ($visit === null) {
            $this->redirectToRoute('forthcoming_visits');
        }

        $form = $this->createForm(VisitType::class, $visit);
        $this->visitService->deleteVisitUsers($id);
        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($visit);

        if (count($errors) > 0) {
            return $this->render('visit/add_visit.html.twig', array(
                'form' => $form->createView(),
                'id' => $id,
                'errors' => $errors,
                'customer' => $customer,
                'visit' => $visit
            ));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->visitService->editVisit($visit);

            $this->addFlash('message', "Visit to " . $customer->getName() . " edited successfully!");
            return $this->redirectToRoute("forthcoming_visits");
        }

        return $this->render('visit/add_visit.html.twig', array(
            'form' => $form->createView(),
            'id' => $id,
            'errors' => $errors,
            'customer' => $customer,
            'visit' => $visit
        ));
    }


    /**
     * @Route("/delete/{id}", name="delete_visit")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $visit = $this->visitService->getVisitById($id);
        $customer = $visit->getCustomer();

        if ($visit === null) {
            $this->redirectToRoute('forthcoming_visits');
        }

        $this->visitService->deleteVisit($visit);

        $this->addFlash('message', "Visit to " . $customer->getName() . " deleted successfully!");
        return $this->redirectToRoute('forthcoming_visits');
    }

    /**
     * @Route("/forthcoming" ,name="forthcoming_visits")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listForthcomingAction(Request $request)
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

        /** @var Visit[] $visits */
        $visits = $this->visitService->getAllVisits($year, $month, false);
        $viewName = 'All Planned ';

        return $this->render('visit/all_visits.html.twig', [
            'visits' => $visits,
            'viewName' => $viewName,
            'form' => $form->createView(),
            'year' => $year,
            'month' => date("F", strtotime($year . "-" . $month . "-01"))
        ]);
    }

    /**
     * @Route("/finished", name="finished_visits")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAllAction(Request $request)
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

        $visits = $this->visitService->getAllVisits($year, $month, true);
        $viewName = 'All Past ';

        return $this->render('visit/all_visits.html.twig', [
            'visits' => $visits,
            'viewName' => $viewName,
            'form' => $form->createView(),
            'year' => $year,
            'month' => date("F", strtotime($year . "-" . $month . "-01"))
        ]);
    }

    /**
     * @Route("/by-customer/{id}" ,name="all_customer_visits")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAllByCustomerAction($id, Request $request)
    {
        /** @var Customer $customer */
        $customer = $this->customerService->getCustomerById($id);

        $form = $this->createForm(YearType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $year = $data['year'];
        } else {
            $date = new \DateTime();
            $year = $date->format('Y');
        }

        $visits = $this->visitService->getAllByCustomer($customer, $year, true);
        $viewName = 'Past ' . $customer->getName();

        return $this->render('visit/all_visits_by_id.html.twig', [
            'visits' => $visits,
            'viewName' => $viewName,
            'form' => $form->createView(),
            'year' => $year,
            'customer' => $customer
        ]);
    }

    /**
     * @Route("/planned-by-customer/{id}", name="planned_customer_visits")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listForthcomingByCustomerAction($id, Request $request)
    {
        /** @var Customer $customer */
        $customer = $this->customerService->getCustomerById($id);

        $form = $this->createForm(YearType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $year = $data['year'];
        } else {
            $date = new \DateTime();
            $year = $date->format('Y');
        }

        $visits = $this->visitService->getAllByCustomer($customer, $year, false);
        $viewName = 'Planned ' . $customer->getName();

        return $this->render('visit/all_visits_by_id.html.twig', [
            'visits' => $visits,
            'viewName' => $viewName,
            'form' => $form->createView(),
            'year' => $year,
            'customer' => $customer
        ]);
    }

    /**
     * @Route("/my-visits", name="my_visits")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listForthcomingByUserAction(Request $request)
    {
        $userId = $this->getUser()->getId();
        $viewName = 'My Planned ';

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

        $visits = $this->visitService->getAllByUser($userId, $year, $month, false);

        return $this->render('visit/all_visits.html.twig', [
            'visits' => $visits,
            'viewName' => $viewName,
            'form' => $form->createView(),
            'year' => $year,
            'month' => date("F", strtotime($year . "-" . $month . "-01"))
        ]);
    }

    /**
     * @Route("/my-past-visits", name="my_past_visits")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listPastByUserAction(Request $request)
    {
        $userId = $this->getUser()->getId();
        $viewName = 'My Past ';

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

        $visits = $this->visitService->getAllByUser($userId, $year, $month, true);

        return $this->render('visit/all_visits.html.twig', [
            'visits' => $visits,
            'viewName' => $viewName,
            'form' => $form->createView(),
            'year' => $year,
            'month' => date("F", strtotime($year . "-" . $month . "-01"))
        ]);
    }

    /**
     * @Route("/finish/{id}" ,name="finish_visit")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function finishVisitAction($id)
    {
        /** @var Visit $visit */
        $visit = $this->visitService->getVisitById($id);

        if ($visit->getIsRegular() === true) {
            $this->visitService->scheduleVisit($visit);
        }

        $this->visitService->finishVisit($id);
        $this->addFlash('message', "Visit successfully finished!");


        return $this->redirectToRoute('forthcoming_visits');
    }
}
