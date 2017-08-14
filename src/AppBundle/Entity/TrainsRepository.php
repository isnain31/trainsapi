<?php

namespace AppBundle\Entity;
use Doctrine\ORM\EntityRepository;


class TrainsRepository extends EntityRepository
{
    public function findAllLatestFirst()
    {
	return $this->getEntityManager()
			->createQuery(
			'SELECT t FROM AppBundle:Trains t ORDER BY t.trainNumber DESC'
			)
			->getResult();
    }

   

}
