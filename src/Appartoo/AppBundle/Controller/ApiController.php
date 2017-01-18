<?php

namespace Appartoo\AppBundle\Controller;

use Appartoo\AppBundle\Entity\Contact;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Controleur de l'API rest.
 */
class ApiController extends Controller
{
    /**
     * @param $id
     *
     * @return Response
     */
    public function getUserAction($id)
    {
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

    /**
     * @return Response
     */
    public function getAllUserAction()
    {
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

    /**
     * @param $id
     *
     * @return Response
     */
    public function getContactAction($id)
    {
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

    /**
     * @return Response
     */
    public function getAllContactAction()
    {
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

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function addContactAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $response = new Response();
        try {
            $contact = new Contact();
            $contact->setIdUser($request->get('idUser'));
            $contact->setAddress($request->get('address'));
            $contact->setEmail($request->get('email'));
            $contact->setUrl($request->get('url'));
            $contact->setTelephone($request->get('telephone'));
            $em->persist($contact);
            $em->flush();
            $response->setContent(json_encode(array('success' => true)));
            $response->setStatusCode(200);
        } catch (Exception $e) {
            $response->setContent(json_encode(array('success' => false)));
            $response->setStatusCode(403);
        }

        return $response;
    }
}
