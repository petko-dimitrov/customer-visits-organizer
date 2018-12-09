<?php

namespace CVOBundle\Controller;

use CVOBundle\Entity\Role;
use CVOBundle\Entity\User;
use CVOBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
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



        if ($form->isSubmitted() && $form->isValid()) {
            $username = $form->getData()->getUsername();
            $userToCheck = $this->getDoctrine()
                ->getRepository(User::class)
                ->findBy(['username' => $username]);

            if (null != $userToCheck) {
                $this->addFlash('message', "User with username $username is already registered!");
                return $this->render("user/register.html.twig");
            }

            $password = $this->get("security.password_encoder")
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $roleRepository = $this->getDoctrine()->getRepository(Role::class);
            $userRepository = $this->getDoctrine()->getRepository(User::class);

            $usersFromDB = $userRepository->findAll();

            $em = $this->getDoctrine()->getManager();


            if ($usersFromDB == null) {
                $role = new Role();
                $role->setName('ROLE_ADMIN');
                $em->persist($role);

                $user->addRole($role);

                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('security_login');
            }

            $userRole = $roleRepository->findOneBy(['name' => 'ROLE_USER']);

            if ($userRole == null) {
                $userRole = new Role();
                $userRole->setName('ROLE_USER');
                $em->persist($userRole);
            }

            $user->addRole($userRole);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('user/register.html.twig', array('form' => $form->createView()));
    }
}
