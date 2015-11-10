<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\FooType;
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
        $form = $this->createForm(new FooType());

        return $this->render('default/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
