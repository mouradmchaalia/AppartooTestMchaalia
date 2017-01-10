<?php

namespace Appartoo\AppBundle\Controller;

use Appartoo\AppBundle\Entity\Contact;
use Appartoo\AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ApiController extends Controller {

    public function getUserAction($id) {
        $em = $this->getDoctrine()->getManager();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $user = $em->getRepository('AppartooAppBundle:User')->find($id);
        $data = $serializer->serialize($user, 'json');

        $response = new Response();
        $response->setContent($data);
        $response->setStatusCode(200);
        return $response;
    }

    public function getAllUserAction() {
        $em = $this->getDoctrine()->getManager();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $user = $em->getRepository('AppartooAppBundle:User')->findAll();
        $data = $serializer->serialize($user, 'json');

        $response = new Response();
        $response->setContent($data);
        $response->setStatusCode(200);
        return $response;
    }

    public function getContactAction($id) {
        $em = $this->getDoctrine()->getManager();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $contact = $em->getRepository('AppartooAppBundle:Contact')->find($id);
        $data = $serializer->serialize($contact, 'json');

        $response = new Response();
        $response->setContent($data);
        $response->setStatusCode(200);
        return $response;
    }

    public function getAllContactAction() {
        $em = $this->getDoctrine()->getManager();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $contact = $em->getRepository('AppartooAppBundle:Contact')->findAll();
        $data = $serializer->serialize($contact, 'json');

        $response = new Response();
        $response->setContent($data);
        $response->setStatusCode(200);
        return $response;
    }

    public function addContactAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $response = new Response();
        try {
            $contact = new Contact();
            $contact->setIdUser($request->get("idUser"));
            $contact->setAdresse($request->get("adresse"));
            $contact->setEmail($request->get("email"));
            $contact->setSiteWeb($request->get("siteWeb"));
            $contact->setTelephone($request->get("telephone"));
            $em->persist($contact);
            $em->flush();
            $response->setContent(json_encode(array("success" => TRUE)));
            $response->setStatusCode(200);
        } catch (Exception $e) {
            $response->setContent(json_encode(array("success" => FALSE)));
            $response->setStatusCode(403);
        }
        return $response;
    }

    public function addUserAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $response = new Response();
        try {
            $user = new User();
            $user->setUsername($request->get("username"));
            $user->isEnabled(1);
            $user->setPlainPassword($request->get("password"));
            $user->setEmail($request->get("email"));
            $user->addRole("ROLE_USER");
            $em->persist($user);
            $em->flush();
            $response->setStatusCode(200);
            $$response->setContent(json_encode(array("success" => TRUE)));
        } catch (Exception $e) {
            $$response->setContent(json_encode(array("success" => FALSE)));

            $response->setStatusCode(403);
        }
        return $response;
    }

}
