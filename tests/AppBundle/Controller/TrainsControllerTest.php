<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;



class TrainsControllerTest extends WebTestCase
{

    static $inserted_id;	

    public function testAddTrainAction(){
    
        $client = static::createClient();

	$data = array(
        'trainName' => "Test Train",
        'buildYear' => 2017,
        'trainType' => 'electrical'
        );
        $crawler = $client->request('POST','/train/add',$data,array(),array('CONTENT_TYPE' => 'application/json'));
	$client->getResponse()->getContent();

	$respnose_object=json_decode($client->getResponse()->getContent());
	
	self::$inserted_id=$respnose_object->train_number;

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    public function testUpdateTrainAction(){

	
        $client = static::createClient();

	$data = array(
        'trainName' => "Test Train Changed",
        'buildYear' => 2017,
        'trainType' => 'steam',
	);

        $crawler = $client->request('PUT','/train/'.self::$inserted_id,$data,array(),array('CONTENT_TYPE' => 'application/json'));


        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }	


    public function testGetTrainsAction(){
	$client = static::createClient();
	$crawler = $client->request('GET', '/train/'.self::$inserted_id);

	$this->assertEquals(200, $client->getResponse()->getStatusCode());
	
    }	
	
    public function testGetAllTrainsAction(){

        $client = static::createClient();
        $crawler = $client->request('GET', '/trains/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
	
    }

    public function testDeleteTrainAction(){

        $client = static::createClient();
        $crawler = $client->request('DELETE', '/train/'.self::$inserted_id);
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
	
    } 	
    	

}
