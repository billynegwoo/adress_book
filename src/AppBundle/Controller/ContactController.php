<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Contact;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contact controller.
 *
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     * delete a User contact.
     *
     * @Route("/delete", name="user_contact_delete")
     * @Method("POST")
     */
    public function deleteUserContactAction(Request $request){
        $params = json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(['username' => $params->me]);
        $em->getRepository('AppBundle:Contact')->deleteContact($user->getId(), $params->id);
        return new JsonResponse(['message'=>'success']);
    }


    /**
     * Get all User contacts.
     *
     * @Route("/{username}", name="user_contact")
     * @Method("GET")
     */
    public function userContactAction($username)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->findOneBy(['username' => $username]);

        $contacts = $em->getRepository('AppBundle:Contact')->getUserContacts($user->getId());
        return new JsonResponse(['contacts' => $contacts]);

    }

    /**
     * find a contact.
     *
     * @Route("/find/{username}", name="find_contact")
     * @Method("GET")
     */
    public function findAction($username){
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:Contact')->searchContact($username);

        return new JsonResponse($user);
    }

    /**
     * add a  contact.
     *
     * @Route("/add", name="add_contact")
     * @Method("POST")
     */
    public function addContactAction(Request $request){
        $params = json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(['username' => $params->me]);
        $contact = new Contact();
        $contact->setContactId($params->id);
        $contact->setUserId($user->getId());
        $em->persist($contact);
        $em->flush();
        return new JsonResponse(['message'=>$contact]);
    }

}
