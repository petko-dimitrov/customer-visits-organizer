<?php

namespace CVOBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $user = $this->getUser();

        if (null === $user) {
            return $this->redirectToRoute('security_login');
        }

        return $this->redirectToRoute('forthcoming_visits');
    }
}
