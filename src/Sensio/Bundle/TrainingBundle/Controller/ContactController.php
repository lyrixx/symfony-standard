<?php

namespace Sensio\Bundle\TrainingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\TrainingBundle\Contact\Contact;
use Sensio\Bundle\TrainingBundle\Form\ContactType;
use Sensio\Bundle\TrainingBundle\Mail\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     * @Template()
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $mail = new Mail($this->get('mailer'), $this->get('templating'));
            $mail->sendContactMail($contact);

            $request->getSession()->getFlashBag()->add('success', 'Thanks you for...');

            return $this->redirect($this->generateUrl('contact'));
        }

        return array('contact_form' => $form->createView());
    }
}
