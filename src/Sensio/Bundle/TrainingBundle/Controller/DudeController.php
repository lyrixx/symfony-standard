<?php

namespace Sensio\Bundle\TrainingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\TrainingBundle\Entity\Dude;
use Sensio\Bundle\TrainingBundle\Form\DudeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/dude")
 * @Template()
 */
class DudeController extends Controller
{
    /**
     * @Route("", name="dude_list")
     */
    public function listAction(Request $request)
    {
        $dudes = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SensioTrainingBundle:Dude')
            ->findAll()
        ;

        return array(
            'dudes' => $dudes,
            'token' => $this->get('form.csrf_provider')->generateCsrfToken('dude_delete'),
        );
    }

    /**
     * @Route("/new", name="dude_new")
     */
    public function newAction(Request $request)
    {
        $dude = new Dude();
        $form = $this->createForm(new DudeType(), $dude);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dude);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'The dude has been saved');

            return $this->redirect($this->generateUrl('dude_list'));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/edit/{id}", name="dude_edit")
     */
    public function editAction(Request $request, Dude $dude)
    {
        $form = $this->createForm(new DudeType(), $dude);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->getFlashBag()->add('success', 'The dude has been updated');

            return $this->redirect($this->generateUrl('dude_list'));
        }

        return array('form' => $form->createView(), 'dude' => $dude);
    }

    /**
     * @Route("/delete/{id}/{token}", name="dude_delete")
     */
    public function deleteAction(Request $request, Dude $dude, $token)
    {
        if (!$this->get('form.csrf_provider')->isCsrfTokenValid('dude_delete', $token)) {
            throw $this->createNotFoundException('Token no valid');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($dude);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'The dude has been removed');

        return $this->redirect($this->generateUrl('dude_list'));
    }
}
