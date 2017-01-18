<?php

namespace Appartoo\AppBundle\Controller;

use Appartoo\AppBundle\Entity\Contact;
use Exception;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


/**
 * Rest Api Controller.
 */
class ApiController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  resource=true,
     *  section="User",
     *  description="This Api returns a user Data from database",
     *  responseMap = {
     *      200 = {
     *          "class" = Appartoo\AppBundle\Entity\User::class,
     *      }
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when the url is malformed",
     *      500="Returned when a technical error occurs, request must be retry"
     *  }
     * )
     * @param $id
     *
     * @return Response
     */
    public function getUserAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('AppartooAppBundle:User')->find($id);
        $view = $this->view($user, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Get("/users",requirements={"_format"="json|xml|html"},defaults={"_format" = "json"}, name="get_users")
     * @ApiDoc(
     *  resource=true,
     *  section="User",
     *  description="This Api returns all users Data from database",
     *  responseMap = {
     *      200 = {
     *          "class" = Appartoo\AppBundle\Entity\User::class,
     *      }
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when the url is malformed",
     *      500="Returned when a technical error occurs, request must be retry"
     *  }
     * )
     * @return Response
     */
    public function getUsersAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $userList = $em->getRepository('AppartooAppBundle:User')->findAll();
        $view = $this->view($userList, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  section="Contact",
     *  description="This Api returns a contact Data from database",
     *  responseMap = {
     *      200 = {
     *          "class" = Appartoo\AppBundle\Entity\Contact::class,
     *      }
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when the url is malformed",
     *      500="Returned when a technical error occurs, request must be retry"
     *  }
     * )
     * @param $id
     *
     * @return Response
     */
    public function getContactAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $contact = $em->getRepository('AppartooAppBundle:User')->find($id);
        $view = $this->view($contact, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Get("/contacts",requirements={"_format"="json|xml|html"},defaults={"_format" = "json"}, name="get_all_contacts")
     * @ApiDoc(
     *  resource=true,
     *  section="Contact",
     *  description="This Api returns all contact Data from database",
     *  responseMap = {
     *      200 = {
     *          "class" = Appartoo\AppBundle\Entity\Contact::class,
     *      }
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when the url is malformed",
     *      500="Returned when a technical error occurs, request must be retry"
     *  }
     * )
     * @return Response
     */
    public function getAllContactAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $contactList = $em->getRepository('AppartooAppBundle:Contact')->findAll();
        $view = $this->view($contactList, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Post("/contacts/",requirements={"_format"="json|xml|html"},defaults={"_format" = "json"}, name="add_contact")
     * @param Request $request
     * @ApiDoc(
     *  resource=true,
     *  section="Contact",
     *  description="add a neww contact",
     *  input={
     *       "class"="Appartoo\AppBundle\Entity\Contact"
     *  },
     *  responseMap = {
     *      200 = {
     *          "class" = Appartoo\AppBundle\Entity\Contact::class,
     *      }
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when the url is malformed",
     *      500="Returned when a technical error occurs, request must be retry"
     *  }
     * )
     * @return Response
     */
    public function addContactAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        try {
            $contact = new Contact();
            $contact->setIdUser($request->get('idUser'));
            $contact->setAddress($request->get('address'));
            $contact->setEmail($request->get('email'));
            $contact->setUrl($request->get('url'));
            $contact->setPhone($request->get('phone'));
            $em->persist($contact);
            $em->flush();

            $view = $this->view(['success' => true], Response::HTTP_OK);

        } catch (Exception $e) {
            $view = $this->view(['success' => true, 'error'=>$e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->handleView($view);
    }
}
