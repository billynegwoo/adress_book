<?php
namespace AppBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;

class RegistrationController extends BaseController{
    public function confirmedAction(){
        parent::confirmedAction();

        return $this->redirect($this->generateUrl('homepage'));

    }
}