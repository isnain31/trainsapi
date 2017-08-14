<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\View\View;
use AppBundle\Entity\Trains;


class TrainsController extends FOSRestController
{

         /**
          * @Rest\Get("/trains/")
	 */
	 public function getAllTrainsAction()
	 {
	   try{
	   	 $trains=$this->get("train")->get();	 	
	  	 return $trains; 
	   }
	   catch(\Exception $e){
		echo $e->getMessage();
		return new View("", Response::HTTP_BAD_REQUEST);
	    } 		
	    
	 }	


	 /**
          * @Rest\Get("/train/{number}")
	 */
	 public function getTrainAction(int $number)
	 {
           try{
	   	$train=$this->get("train")->get($number);	
           	return $train;
	   }
	   catch(\Exception $e){
		return new View("", Response::HTTP_BAD_REQUEST);
	    }	
	   
	 }


	 /**
	 * @Rest\Post("/train/add")
	 */
	 public function addTrainAction(Request $request)
	 {
	   	
                try{
		     	
		     $train = new Trains;
		     $train=$this->get("train")->save();	 
                     return $train;
		 
		}	catch(\Exception $e){

			return new View("", Response::HTTP_BAD_REQUEST);
		} 		
	   

	 }

	 /**
          * @Rest\Delete("/train/{number}")
	 */
	 public function deleteTrainAction(int $number)
	 {
	   try{
	   
	    $this->get("train")->remove($number);
	    return new View("", Response::HTTP_NO_CONTENT);
	   }	
           catch(\Exception $e){

			return new View("", Response::HTTP_NOT_FOUND);
		} 		
	   
	 }

        /**
	 * @Rest\Put("/train/{number}")
 	*/
	 public function updateAction(int $number,Request $request)
	 { 
	   try{
		   $train = new Trains;
		   $train=$this->get("train")->save($number);
		   return $train;
	   }	
           catch(\Exception $e){

			return new View("", Response::HTTP_BAD_REQUEST);
		}	
	
	 }
    	

}
