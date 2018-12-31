<?php

namespace CVOBundle\Controller;

use CVOBundle\Entity\Customer;
use CVOBundle\Form\CustomerType;
use CVOBundle\Service\Address\AddressServiceInterface;
use CVOBundle\Service\Customer\CustomerServiceInterface;
use CVOBundle\Service\Visit\VisitServiceInterface;
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
    private $addressService;

    public function __construct(CustomerServiceInterface $customerService,
                                AddressServiceInterface $addressService)
    {
        $this->customerService = $customerService;
        $this->addressService = $addressService;
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
                'customer' => $customer,
                'errors' => $errors,
            ));
        }

        if ($customerForm->isSubmitted() && $customerForm->isValid()) {
            $name = $customerForm->getData()->getName();
            $customerToCheck = $this->customerService->checkCustomer($name);

            if (null != $customerToCheck) {
                $this->addFlash('message', "Customer with name $name is already registered!");
                return $this->render("customer/create.html.twig", [
                        'customer_form' => $customerForm->createView(),
                        'customer' => $customer,
                        'errors' => $errors
                    ]);
            }

            $this->customerService->addCustomer($customer);
            $id = $customer->getId();

            return $this->redirectToRoute('add_address', ['id' => $id]);
        }

        return $this->render('customer/create.html.twig', array(
                'customer_form' => $customerForm->createView(),
                'customer' => $customer,
                'errors' => $errors
        ));
    }

    /**
     * @Route("/all", name="all_customers")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAllAction()
    {
        $customers = $this->customerService->getAllCustomers();

        return $this->render('customer/all.html.twig', [
            'customers' => $customers,
            'areActive' => true
        ]);
    }

    /**
     * @Route("/archived", name="archived_customers")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAllArchivedAction()
    {
        $customers = $this->customerService->getAllArchivedCustomers();

        return $this->render('customer/all.html.twig', [
            'customers' => $customers,
            'areActive' => false
        ]);
    }


    /**
     * @Route("/view/{id}", name="view_one")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewOneAction($id)
    {
        $customer = $this->customerService->getCustomerById($id);

        return $this->render('customer/view_one.html.twig',
            ['customer' => $customer]);
    }

    /**
     * @Route("/edit/{id}", name="edit_customer")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $customer = $this->customerService->getCustomerById($id);

        if ($customer === null) {
            $this->redirectToRoute('all_customers');
        }

        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($customer);

        if (count($errors) > 0) {
            return $this->render('customer/create.html.twig', array(
                'customer_form' => $form->createView(),
                'customer' => $customer,
                'errors' => $errors,
            ));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->customerService->editCustomer($customer);

            return $this->redirectToRoute("view_one", ['id' => $id]);
        }

        return $this->render('customer/create.html.twig', array(
                'customer_form' => $form->createView(),
                'customer' => $customer,
                'errors' => $errors
        ));
    }

    /**
     * @Route("/delete/{id}", name="delete_customer")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        /** @var Customer $customer */
        $customer = $this->customerService->getCustomerById($id);

        if ($customer === null) {
            $this->redirectToRoute('all_customers');
        }

        $address = $customer->getAddress();

        $this->addressService->deleteAddress($address);
        $this->customerService->deleteCustomer($customer);

        return $this->redirectToRoute('all_customers');
    }

    /**
     * @Route("/archive/{id}", name="archive_customer")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function archiveAction($id)
    {
        /** @var Customer $customer */
        $customer = $this->customerService->getCustomerById($id);

        if ($customer === null) {
            $this->redirectToRoute('all_customers');
        }

        $this->customerService->archiveCustomer($customer);

        return $this->redirectToRoute('all_customers');
    }

    /**
     * @Route("/activate/{id}", name="activate_customer")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function activateAction($id)
    {
        /** @var Customer $customer */
        $customer = $this->customerService->getCustomerById($id);

        if ($customer === null) {
            $this->redirectToRoute('archived_customers');
        }

        $this->customerService->activateCustomer($customer);

        return $this->redirectToRoute('archived_customers');
    }
}