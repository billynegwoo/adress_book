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
    public function deleteUserContactAction(Request $request)
    {
        $params = json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository('AppBundle:Contact')->find($params->id);
        $em->remove($contact);
        $em->flush();
        return new JsonResponse(['message' => 'success']);
    }


    /**
     * Get all User contacts.
     *
     * @Route("/", name="user_contact")
     * @Method("GET")
     */
    public function userContactAction()
    {
        $myContacts = [];
        $contacts = $this->getUser()->getContacts();
        $i = 0;
        foreach ($contacts as $key => $value) {
            $myContacts[$i]['address'] = $value->getAdress();
            $myContacts[$i]['email'] = $value->getEmail();
            $myContacts[$i]['username'] = $value->getUsername();
            $myContacts[$i]['phone_number'] = $value->getPhoneNumber();
            $myContacts[$i]['id'] = $value->getId();
            $i++;
        }
        return new JsonResponse($myContacts);
    }

    /**
     * find a contact.
     *
     * @Route("/find/{username}", name="find_contact")
     * @Method("GET")
     */
    public function findAction($username)
    {
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
    public function addContactAction(Request $request)
    {
        $params = json_decode($request->getContent());

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($params->id);

        $contact = new Contact();

        $contact->setUser($this->getUser());
        $contact->setAdress($user->getAdress());
        $contact->setPhoneNumber($user->getPhoneNumber());
        $contact->setUsername($user->getUsername());
        $contact->setEmail($user->getEmail());

        $this->getUser()->addContact($contact);
        $em->persist($contact);
        $em->flush();
        return new JsonResponse($contact);
    }

}
