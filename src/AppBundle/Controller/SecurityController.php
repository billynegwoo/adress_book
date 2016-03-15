<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class SecurityController extends BaseController
{
    public function loginAction(Request $request)
    {
       $parent = parent::loginAction($request);
        $session = new Session();
        if($session->get("_security_main"))
        {
            $route = $this->container->get('router')->generate('homepage');
            return new RedirectResponse($route);

        }
        return $parent;
    }
}
