<?php
namespace AppBundle\Service;
use Symfony\Component\HttpFoundation\RequestStack;
use AppBundle\Entity\Trains;


class Train
{
     
	private $request;
	private $em;
	private $trainName;
	private $buildYear;
	private $trainType;
	private $train;


	public function __construct(RequestStack $requestStack,\Doctrine\ORM\EntityManager $em){
	    	$this->request=$requestStack->getCurrentRequest();
		$this->em=$em;
		$this->trainName = $this->request->get('trainName');
		$this->buildYear = $this->request->get('buildYear');
		$this->trainType= $this->request->get('trainType');	
		$this->train= new Trains;
        }
    
	private function setTrain(){
		$this->train->setTrainType($this->trainType);
		$this->train->setTrainName($this->trainName);
		$this->train->setBuildYear($this->buildYear); 
	}

    	public function save(int $number=0){

		
	
		if($number!=0){ // edit
			$this->train = $this->em->getRepository('AppBundle:Trains')->find($number);

			if (empty($this->train)) {
			     return null;
			} 
			else{
				$train=$this->setTrain();
				$this->em->flush();
				return $this->train;
			}
		}
		else{	// save
			$this->setTrain();
			$this->em->persist($this->train);
                        $this->em->flush();
			return $this->train;
		}
			
		
        }

	public function get(int $number=0){
		$train=array();
		if($number!=0){ // get one
			$train = $this->em->getRepository('AppBundle:Trains')->findByTrainNumber($number);
		}
		else{	

			//get all
			$train=$this->em->getRepository('AppBundle:Trains')->findAllLatestFirst();
		}
		return $train;		
	}

	public function remove(int $number){
	   $train = $this->em->getRepository('AppBundle:Trains')->find($number);
	   $this->em->remove($train);
	   $this->em->flush();
	}
		
}

