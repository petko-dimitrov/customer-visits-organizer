<?php

namespace CVOBundle\Controller;

use CVOBundle\Entity\Contact;
use CVOBundle\Form\ContactType;
use CVOBundle\Service\Contact\ContactServiceInterface;
use CVOBundle\Service\Customer\CustomerServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("contact")
 * Class ContactController
 * @package CVOBundle\Controller
 */
class ContactController extends Controller
{
    private $customerService;
    private $contactService;

    public function __construct(CustomerServiceInterface $customerService,
                                ContactServiceInterface $contactService)
    {
        $this->customerService = $customerService;
        $this->contactService = $contactService;
    }

    /**
     * @Route("/add/{id}", name="add_contact")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, $id)
    {
        $customer = $this->customerService->getCustomerById($id);
        $contact = new Contact();

        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($contact);

        if (count($errors) > 0) {
            return $this->render('contact/add_contact.html.twig', array(
                'form' => $contactForm->createView(),
                'id' => $id,
                'errors' => $errors,
                'customer' => $customer
            ));
        }

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {

            $this->contactService->addContact($contact, $id);

            $this->addFlash('message', "Contact for " . $customer->getName() . " added successfully!");
            return $this->redirectToRoute('view_one', [
                'id' => $id
            ]);
        }

        return $this->render('contact/add_contact.html.twig', [
            'form' => $contactForm->createView(),
            'id' => $id,
            'errors' => $errors,
            'customer' => $customer
        ]);
    }


    /**
     * @Route("/edit/{id}", name="edit_contact")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        /** @var Contact $contact */
        $contact = $this->contactService->getContactById($id);

        if ($contact === null) {
            $this->redirectToRoute('all_customers');
        }

        $customer = $contact->getCustomer();
        $customerId = $customer->getId();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($contact);

        if (count($errors) > 0) {
            return $this->render('contact/edit.html.twig', array(
                'form' => $form->createView(),
                'id' => $id,
                'customerId' => $customerId,
                'contact' => $contact,
                'errors' => $errors,
            ));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactService->editContact($contact);

            $this->addFlash('message', "Contact for " . $customer->getName() . " edited successfully!");
            return $this->redirectToRoute("view_one", ['id' => $customerId]);
        }

        return $this->render('contact/edit.html.twig', array(
            'form' => $form->createView(),
            'id' => $id,
            'customerId' => $customerId,
            'contact' => $contact,
            'errors' => $errors,
        ));
    }

    /**
     * @Route("/delete/{id}", name="delete_contact")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        /** @var Contact $contact */
        $contact = $this->contactService->getContactById($id);

        if ($contact === null) {
            $this->redirectToRoute('all_customers');
        }

        $customer = $contact->getCustomer();
        $customerId = $customer->getId();

        $this->contactService->deleteContact($contact);

        $this->addFlash('message', "Contact for " . $customer->getName() . " deleted successfully!");
        return $this->redirectToRoute('view_one', ['id' => $customerId]);
    }
}
