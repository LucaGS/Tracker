<?php

namespace App\Tests\Controller;

use App\Entity\Startedtraining;
use App\Tests\Utils\TransactionalTestCase;

class StartedTrainingControllerTest extends TransactionalTestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::getClient();
    }

 
    public function testGetStartedTrainingplansbyUserIdAndTrainingplanId(): void
    {
        $startedtrainingA = new Startedtraining();
        $startedtrainingA->setUserid(999999999);
        $startedtrainingA->setTrainingplanid(999999999);
        $startedtrainingB = new Startedtraining();
        $startedtrainingB->setUserid(999999999);
        $startedtrainingB->setTrainingplanid(999999999);

        $this->em->persist($startedtrainingA);
        $this->em->persist($startedtrainingB);
        $this->em->flush();

        $this->client->request('GET', '/api/startedtraining/'. $startedtrainingA->getUserid()."/".$startedtrainingA->getTrainingplanid());
        $response = json_decode($this->client->getResponse()->getContent(), true);
       
        $this->assertResponseIsSuccessful();
        $this->assertCount(2, $response);
        $trainingplanIds = array_column($response, 'trainingplanid');
        $this->assertContains(999999999, $trainingplanIds);
        $this->assertContains(999999999, $trainingplanIds);

    }
    public function testCreateStartedTrainingplan():void{
        $this->client->request('POST', '/api/startedtraining/', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'userid' => 99999,
            'trainingplanid' => 99999,
        ]));
        //$this->assertResponseStatusCodeSame(201);
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseStatusCodeSame(201);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals(99999, $response['userid']);
        $this->assertEquals(99999, $response['trainingplanid']);
    }
}