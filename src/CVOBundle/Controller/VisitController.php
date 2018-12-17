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
        $users = $this->userService->getAllUsers();
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
                'users' => $users
            ));
        }

        if ($visitForm->isSubmitted() && $visitForm->isValid()) {

            $users = $visit->getUsers();

            foreach ($users as $user) {
                $user->addVisit($visit);
            }

            $this->visitService->addVisit($visit, $id);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('visit/add_visit.html.twig',
            array('form' => $visitForm->createView(),
                'id' => $id,
                'errors' => $errors,
                'customer' => $customer,
                'users' => $users
            ));
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

        return $this->render('visit/forthcoming.html.twig', [
            'visits' => $visits
        ]);
    }
}
