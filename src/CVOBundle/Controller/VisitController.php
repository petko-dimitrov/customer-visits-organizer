<?php

namespace CVOBundle\Controller;


use CVOBundle\Entity\Visit;
use CVOBundle\Form\VisitType;
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

        if ($visit === null) {
            $this->redirectToRoute('forthcoming_visits');
        }

        $this->visitService->deleteVisit($visit);

        return $this->redirectToRoute('forthcoming_visits');
    }

    /**
     * @Route("/forthcoming" ,name="forthcoming_visits")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listForthcomingAction()
    {
        /** @var Visit[] $visits */
        $visits = $this->visitService->getAllForthcoming();

        return $this->render('visit/all_visits.html.twig', [
            'visits' => $visits,
            'byUser' => false
        ]);
    }

    /**
     * @Route("/my-visits", name="my_visits")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listForthcomingByUserAction()
    {
        $userId = $this->getUser()->getId();

        $visits = $this->visitService->getAllForthcomingByUser($userId);

        return $this->render('visit/all_visits.html.twig', [
            'visits' => $visits,
            'byUser' => true
        ]);
    }

    /**
     * @Route("/all", name="all_visits")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAllAction()
    {
        $visits = $this->visitService->getAll();

        return $this->render('visit/all_visits.html.twig', [
            'visits' => $visits,
            'byUser' => false
        ]);
    }

    /**
     * @Route("/by-customer/{id}" ,name="all_customer_visits")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAllByCustomerAction($id)
    {
        $customer = $this->customerService->getCustomerById($id);
        $visits = $this->visitService->getAllByCustomer($customer);

        return $this->render('visit/all_visits.html.twig', [
            'visits' => $visits,
            'byUser' => false
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

        return $this->redirectToRoute('forthcoming_visits');
    }
}
