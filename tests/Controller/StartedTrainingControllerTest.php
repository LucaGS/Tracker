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

    public function testGetStartedTrainingplanById(): void
    {
        $startedtraining = new Startedtraining();
        $startedtraining->setUserid(999999999);
        $startedtraining->setTrainingplanid(999999999);
        $this->em->persist($startedtraining);
        $this->em->flush();

        $this->client->request('GET', '/api/trainingplan/' . $startedtraining->getId());
        $this->assertResponseIsSuccessful();

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(999999999, $response['trainingplanid']);
        $this->assertEquals(999999999, $response['userid']);
    }
    public function testGetStartedTrainingplanByUserId(): void
    {
        $startedtrainingA = new Startedtraining();
        $startedtrainingA->setUserid(999999999);
        $startedtrainingA->setTrainingplanid(999999999);
        $startedtrainingB = new Startedtraining();
        $startedtrainingB->setUserid(999999999);
        $startedtrainingB->setTrainingplanid(999999998);

        $this->em->persist($startedtrainingA);
        $this->em->persist($startedtrainingB);
        $this->em->flush();

        $this->client->request('GET', '/api/trainingplan/'. $startedtrainingA->getUserid());
        $response = json_decode($this->client->getResponse()->getContent(), true);
       
        $this->assertResponseIsSuccessful();
        $this->assertCount(2, $response);
        $trainingplanIds = array_column($response, 'trainingplanid');
        $this->assertContains(999999999, $trainingplanIds);
        $this->assertContains(999999998, $trainingplanIds);

    }
}