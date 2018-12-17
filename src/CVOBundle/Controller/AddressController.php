<?php

namespace CVOBundle\Controller;

use CVOBundle\Entity\Address;
use CVOBundle\Form\AddressType;
use CVOBundle\Service\Address\AddressServiceInterface;
use CVOBundle\Service\Customer\CustomerServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("address")
 * Class CustomerController
 * @package CVOBundle\Controller
 */
class AddressController extends Controller
{
    private $addressService;
    private $customerService;

    public function __construct(AddressServiceInterface $addressService,
                                CustomerServiceInterface $customerService)
    {
        $this->addressService = $addressService;
        $this->customerService = $customerService;
    }

    /**
     * @Route("/add/{id}", name="add_address")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, $id)
    {
        $customer = $this->customerService->getCustomerById($id);
        $address = new Address();
        $addressForm = $this->createForm(AddressType::class, $address);

        $addressForm->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($address);

        if (count($errors) > 0) {
            return $this->render('address/add_address.html.twig', array(
                'address_form' => $addressForm->createView(),
                'errors' => $errors,
                'id' => $id,
                'customer' => $customer
            ));
        }

        if ($addressForm->isSubmitted() && $addressForm->isValid()) {
            $this->addressService->addAddress($address, $id);

            return $this->redirectToRoute('view_one', ['id' => $id]);
        }

        return $this->render('address/add_address.html.twig', array(
                'address_form' => $addressForm->createView(),
                'errors' => $errors,
                'id' => $id,
                'customer' => $customer
        ));
    }


    /**
     * @Route("/edit/{id}/{addressId}", name="edit_address")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id, $addressId)
    {
        $customer = $this->customerService->getCustomerById($id);
        $address = $this->addressService->getAddressById($addressId);

        if ($address === null) {
            $this->redirectToRoute('view_one', ['id' => $id]);
        }

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($address);

        if (count($errors) > 0) {
            return $this->render('customer/create.html.twig', array(
                'address_form' => $form->createView(),
                'id' => $id,
                'addressId' => $addressId,
                'address' => $address,
                'errors' => $errors,
                'customer' => $customer
            ));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addressService->editAddress($address);

            return $this->redirectToRoute("view_one", ['id' => $id]);
        }

        return $this->render('address/edit.html.twig', array(
                'address_form' => $form->createView(),
                'id' => $id,
                'addressId' => $addressId,
                'address' => $address,
                'errors' => $errors,
                'customer' => $customer
        ));
    }
}
