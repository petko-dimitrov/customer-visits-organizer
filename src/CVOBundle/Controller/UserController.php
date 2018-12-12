<?php

namespace CVOBundle\Controller;

use CVOBundle\Entity\User;
use CVOBundle\Form\UserType;
use CVOBundle\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("register", name="register_user")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return $this->render('user/register.html.twig', array(
                'form' => $form->createView(),
                'errors' => $errors
            ));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $username = $form->getData()->getUsername();
            $userToCheck = $this->userService->checkUser($username);

            if (null != $userToCheck) {
                $this->addFlash('message', "User with username $username is already registered!");
                return $this->render("user/register.html.twig", ['form' => $form->createView()]);
            }

            $password = $this->get("security.password_encoder")
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $usersFromDb = $this->userService->checkIfUsers();

            if ($usersFromDb == null) {
                $this->userService->register($user, 'ROLE_ADMIN');
                return $this->redirectToRoute('security_login');
            }

            $this->userService->register($user, 'ROLE_USER');
            return $this->redirectToRoute('security_login');
        }

        return $this->render('user/register.html.twig', array(
            'form' => $form->createView(),
            'errors' => $errors));
    }
}