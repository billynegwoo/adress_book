<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Contact;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\User;

/**
 * Contact controller.
 *
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     * Get all User contacts.
     *
     * @Route("/{username}", name="user_contact")
     * @Method("GET")
     */
    public function userContactAction($username){
        $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findOneBy(['username' => $username]);
        $em = $this->getDoctrine()->getManager();
        $contacts = $em->getRepository('AppBundle:Contact')->getUserContacts($user->getId());
        return new JsonResponse(['contacts'=>$contacts]);
    }
}
