<?php

namespace Acme\DemoBundle\Controller;

use Acme\DemoBundle\Form\DebugType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DebugController extends Controller
{
    /**
     * @Route("/debug", name="form_debug")
     * @Template()
     * @Method("POST")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new DebugType());

        $form->bind($request);

        return new Response($form->get('myCheckbox')->getData() ? 'yes' : 'no');
    }
}
