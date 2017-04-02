<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ParserController extends Controller
{
    /**
     * @Route("/parser", name="parser")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $parser = $this->get('app.htmlParser');
        $jobs = $parser->parseHtml();
        
        foreach ($jobs as $job)
        {
            //$em->persist($job);
        }
        $em->flush();
        
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
