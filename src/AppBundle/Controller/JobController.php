<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of JobsController
 *
 * @author Blety
 */
class JobController extends FOSRestController 
{
    /**
     * @Rest\View()
     * @Rest\Get("/jobs")
     * 
     * @return JsonResponse
     */
    public function getJobsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $jobs = $em->getRepository('AppBundle:Job')->findAll();
        
        if (empty($jobs)) {
            return new JsonResponse(array(
                'message' => 'No job found'
            ), Response::HTTP_NOT_FOUND);
        }
        
        return $jobs;
    }
    
    /**
     * @Rest\View()
     * @Rest\Get("/jobs/{id}")
     * @param int $id
     * @return JsonResponse
     */
    public function getJobAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $job = $em->getRepository("AppBundle:Job")->find($id);
        
        if (is_null($job)) {
            return new JsonResponse(['message' => 'Job not found'], Response::HTTP_NOT_FOUND);
        }

        return $job;
    }
}
