<?php

namespace App\Tests\Controller;

use App\Entity\Excercise;
use App\Entity\Startedexcercise;
use App\Tests\Utils\TransactionalTestCase;

class StartedExcerciseControllerTest extends TransactionalTestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::getClient();
    }

    public function testCreateStartedExcercise():void{
        $this->client->request('POST', '/api/startedexcercise/', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'userid' => 99999,
            'trainingplanid' => 99999,
            'excerciseid' => 99999,
            'startedtrainingplanid' => 99999,
            'set' => 1,
            'reps' => 12,
            'weight' => 99.99,
        ]));
        //$this->assertResponseStatusCodeSame(201);
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseStatusCodeSame(201);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals(99999, $response['userid']);
        $this->assertEquals(99999, $response['trainingplanid']);
    }
    public function testGetStartedExcercisesByUserIdAndTrainingplanId(): void
    {
 
        $startedexcerciseA = (new Startedexcercise())
            ->setUserid(999999999)
            ->setExcerciseid(999999999)
            ->setTrainingplanid(999999999)
            ->setStartedtrainingplanid(999999999) 
            ->setSet(1)
            ->setReps(10)
            ->setWeight(100);
        
    
        

        $this->em->persist($startedexcerciseA);
        $this->em->flush();

        $this->client->request('GET', '/api/startedexcercise/999999999/999999999');
        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertCount(1, $response);
        $trainingplanIds = array_column($response, 'trainingplanid');
        $this->assertContains(999999999, $trainingplanIds);
        $this->assertContains(999999999, $trainingplanIds);

    }
    public function testGetStartedExcercisesByUserIdAndExcerciseId(): void
    {
        $startedexcerciseA = (new Startedexcercise())
            ->setUserid(999999999)
            ->setExcerciseid(999999999)
            ->setTrainingplanid(999999999)
            ->setStartedtrainingplanid(999999999) 
            ->setSet(1)
            ->setReps(10)
            ->setWeight(100);
      

        $this->em->persist($startedexcerciseA);
        $this->em->flush();

        $this->client->request('GET', '/api/startedexcercise/999999999/999999999');
        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertCount(1, $response);
        $trainingplanIds = array_column($response, 'trainingplanid');
        $this->assertContains(999999999, $trainingplanIds);
        $this->assertContains(999999999, $trainingplanIds);

    }
}