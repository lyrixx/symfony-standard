<?php

namespace AppBundle\Controller;

use AppBundle\Form\DTO\Email;
use AppBundle\Form\Type\EmailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(EmailType::class, new Email());

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
