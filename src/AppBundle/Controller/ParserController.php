<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\JobType;

class ParserController extends Controller
{
    /**
     * @Route("/parser", name="parser")
     */
    public function indexAction(Request $request)
    {        
        $parser = $this->get('app.html_parser');
        $jobs = $parser->parseHtml();

        $form = $this->createForm(JobType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getRepository('AppBundle:Job')->saveJobs($jobs);
            $this->get('session')->getFlashbag()->add('success','Content parsed ! Check your database.');
        }elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->get('session')->getFlashbag()->add('error','An error occured, please try again.');
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
