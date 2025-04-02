<?php

namespace App\Tests\Controller;

use App\Entity\Excercise;
use App\Tests\Utils\TransactionalTestCase;

class ExcerciseControllerTest extends TransactionalTestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::getClient();
    }

    public function testIndexReturnsExcerciseList(): void
    {
        $excercise = new Excercise();
        $excercise->setName('Test Übung');
        $excercise->setSets(4);
        $excercise->setUserid(999);
        $excercise->setTrainingplanid(555);
        $this->em->persist($excercise);
        $this->em->flush();

        $this->client->request('GET', '/api/excercise');
        $this->assertResponseIsSuccessful();

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
    }

    public function testCreateExcercise(): void
    {
        $payload = [
            'name' => 'Bench Press',
            'sets' => 3,
            'userid' => 1234,
            'trainingplanid' => 9876,
        ];

        $this->client->request('POST', '/api/excercise', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], json_encode($payload));

        $this->assertResponseStatusCodeSame(201);

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Bench Press', $response['name']);
        $this->assertEquals(3, $response['sets']);
        $this->assertEquals(1234, $response['userid']);
        $this->assertEquals(9876, $response['trainingplanid']);
    }

    public function testGetUserExcercisesByPlan(): void
    {
        $uid = 5555;
        $planid = 4444;

        $ex1 = new Excercise();
        $ex1->setName('Squat');
        $ex1->setSets(3);
        $ex1->setUserid($uid);
        $ex1->setTrainingplanid($planid);

        $ex2 = new Excercise();
        $ex2->setName('Deadlift');
        $ex2->setSets(4);
        $ex2->setUserid($uid);
        $ex2->setTrainingplanid($planid);

        $this->em->persist($ex1);
        $this->em->persist($ex2);
        $this->em->flush();

        $this->client->request('GET', "/api/excercise/$uid/$planid");

        $this->assertResponseStatusCodeSame(201); // wie im Controller
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertIsArray($response);
        $this->assertCount(2, $response);
        $this->assertEquals('Squat', $response[0]['name']);
        $this->assertEquals('Deadlift', $response[1]['name']);
    }

    public function testCreateExcerciseWithMissingFields(): void
    {
        $this->client->request('POST', '/api/excercise', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], json_encode([
            'name' => 'Incomplete'
            // kein userid, trainingplanid, sets
        ]));

        $this->assertResponseStatusCodeSame(200); // weil Controller json mit Fehler sendet, kein 4xx
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('error', $response);
    }
}
