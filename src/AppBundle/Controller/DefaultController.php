<?php

namespace AppBundle\Controller;

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
        $form = $this->createForm(EmailType::class);

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
