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
 * @Route("customer")
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
            return $this->render('address/add_address.html.twig', array(
                'form' => $contactForm->createView(),
                'id' => $id,
                'errors' => $errors,
                'customer' => $customer
            ));
        }

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {

            $this->contactService->addContact($contact, $id);

            return $this->redirectToRoute('all_customers');
        }

        return $this->render('customer/add_contact.html.twig', [
            'form' => $contactForm->createView(),
            'id' => $id,
            'errors' => $errors,
            'customer' => $customer
        ]);
    }
}
