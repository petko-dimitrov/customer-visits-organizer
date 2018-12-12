<?php

namespace CVOBundle\Controller;

use CVOBundle\Entity\Customer;
use CVOBundle\Form\CustomerType;
use CVOBundle\Service\Customer\CustomerServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("customer")
 * Class CustomerController
 * @package CVOBundle\Controller
 */
class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerServiceInterface $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * @Route("/create", name="create_customer")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $customer = new Customer();
        $customerForm = $this->createForm(CustomerType::class, $customer);
        $customerForm->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($customer);

        if (count($errors) > 0) {
            return $this->render('customer/create.html.twig', array(
                'customer_form' => $customerForm->createView(),
                'errors' => $errors,
            ));
        }

        if ($customerForm->isSubmitted() && $customerForm->isValid()) {
            $name = $customerForm->getData()->getName();
            $customerToCheck = $this->customerService->checkCustomer($name);

            if (null != $customerToCheck) {
                $this->addFlash('message', "Customer with name $name is already registered!");
                return $this->render("customer/create.html.twig", ['customer_form' => $customerForm->createView()
                ,'errors' => $errors]);
            }

            $this->customerService->addCustomer($customer);
            $id = $customer->getId();

            return $this->redirectToRoute('add_address', ['id' => $id]);
        }

        return $this->render('customer/create.html.twig',
            array('customer_form' => $customerForm->createView()
            , 'errors' => $errors));
    }
}
