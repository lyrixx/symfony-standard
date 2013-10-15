<?php

namespace Sensio\Bundle\TrainingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\TrainingBundle\Contact\Contact;
use Sensio\Bundle\TrainingBundle\Form\ContactType;
use Sensio\Bundle\TrainingBundle\Mail\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
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
            $mailer = new Mailer($this->get('mailer'), $this->get('templating'));
            if ($mailer->sendContactMail($contact)) {
                $request->getSession()->getFlashBag()->add('success', 'Thanks you for...');

                return $this->redirect($this->generateUrl('contact'));
            }

            $form->addError(new FormError('We could not send an email, please try again later'));
        }

        return array('contact_form' => $form->createView());
    }
}
