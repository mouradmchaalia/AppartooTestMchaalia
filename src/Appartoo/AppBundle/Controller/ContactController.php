<?php

namespace Appartoo\AppBundle\Controller;

use Appartoo\AppBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controleur du contact.
 */
class ContactController extends Controller
{
    /**
     * Method returning list of all contacts
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $id = $user->getId();
        $contacts = $em->getRepository('AppartooAppBundle:Contact')->findByIdUser($id);

        return $this->render('AppartooAppBundle:Default:index.html.twig', array(
            'contacts' => $contacts,
        ));
    }

    /**
     * Method to add new Contact
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm('Appartoo\AppBundle\Form\ContactType', $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
            $contact->setIdUser($id);
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('contact_show', array('id' => $contact->getId()));
        }

        return $this->render('AppartooAppBundle:Default:new.html.twig', array(
            'contact' => $contact,
            'form' => $form->createView(),
        ));
    }

    /**
     * This shows a single contact details with the delete form
     *
     * @param Contact $contact
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Contact $contact)
    {
        $deleteForm = $this->createDeleteForm($contact);

        return $this->render('AppartooAppBundle:Default:show.html.twig', array(
            'contact' => $contact,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Allow to edit a selected contact using edit form generated in the view
     *
     * @param Request $request
     * @param Contact $contact
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Contact $contact)
    {
        $deleteForm = $this->createDeleteForm($contact);
        $editForm = $this->createForm('Appartoo\AppBundle\Form\ContactType', $contact);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_edit', array('id' => $contact->getId()));
        }

        return $this->render('AppartooAppBundle:Default:edit.html.twig', array(
            'contact' => $contact,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Method to delete a  selected contact
     *
     * @param Request $request
     * @param Contact $contact
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Contact $contact)
    {
        $form = $this->createDeleteForm($contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contact);
            $em->flush();
        }

        return $this->redirectToRoute('appartoo_app_homepage');
    }

    /**
     * A private method called in deleteAction to create a delete Form
     *
     * @param Contact $contact
     *
     * @return mixed
     */
    private function createDeleteForm(Contact $contact)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contact_delete', array('id' => $contact->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
