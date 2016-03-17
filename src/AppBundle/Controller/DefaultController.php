<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', ['user' => $this->get('security.token_storage')->getToken()->getUser()]);
    }

    /**
     * @Route("/currentuser")
     */
    public function  getCurrentUser()
    {
        return new JsonResponse($this->container->get('security.context')->getToken()->getUser());
    }
}
