<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * JobRepository
 *
 */
class JobRepository extends EntityRepository
{
    public function saveJobs($jobs)
    {
        $em = $this->getEntityManager();

        foreach ($jobs as $job) {
            $em->persist($job);
        }

        $em->flush();

        return true;
    }
}
