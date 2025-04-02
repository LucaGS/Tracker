<?php

namespace App\Tests\Controller;

use App\Entity\Trainingplan;
use App\Tests\Utils\TransactionalTestCase;

class TrainingplanControllerTest extends TransactionalTestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::getClient();
    }

    public function testCreateTrainingplan(): void
    {
        $this->client->request('POST', '/api/trainingplan/', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'name' => 'Push/Pull Plan',
            'userid' => 42,
        ]));

        $this->assertResponseStatusCodeSame(201);

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Push/Pull Plan', $response['name']);
        $this->assertEquals(42, $response['userid']);
        $this->assertArrayHasKey('id', $response);
    }

    public function testGetTrainingplanById(): void
    {
        $plan = new Trainingplan();
        $plan->setName('Leg Day');
        $plan->setUserid(99);
        $this->em->persist($plan);
        $this->em->flush();

        $this->client->request('GET', '/api/trainingplan/' . $plan->getId());
        $this->assertResponseIsSuccessful();

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Leg Day', $response['name']);
        $this->assertEquals(99, $response['userid']);
    }

    public function testUpdateTrainingplan(): void
    {
        $plan = new Trainingplan();
        $plan->setName('Old Name');
        $plan->setUserid(99999999);
        $this->em->persist($plan);
        $this->em->flush();

        $this->client->request('PUT', '/api/trainingplan/' . $plan->getId(), [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'name' => 'Updated Name',
        ]));

        $this->assertResponseIsSuccessful();

        $updated = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Updated Name', $updated['name']);
        $this->assertEquals(99999999, $updated['userid']); // sollte unverändert sein
    }

    public function testDeleteTrainingplan(): void
{
    $plan = new Trainingplan();
    $plan->setName('To be deleted');
    $plan->setUserid(1);
    $this->em->persist($plan);
    $this->em->flush();

    // 💾 ID vorher merken
    $id = $plan->getId();

    $this->client->request('DELETE', '/api/trainingplan/' . $id);
    $this->assertResponseStatusCodeSame(204);

    // ✅ Jetzt kannst du sicher nach der ID suchen
    $deleted = $this->em->getRepository(Trainingplan::class)->find($id);
    $this->assertNull($deleted);
}

    public function testGetPlansByUserId(): void
    {
        $plan1 = new Trainingplan();
        $plan1->setName('Plan A');
        $plan1->setUserid(99999999);

        $plan2 = new Trainingplan();
        $plan2->setName('Plan B');
        $plan2->setUserid(99999999);

        $this->em->persist($plan1);
        $this->em->persist($plan2);
        $this->em->flush();

        $this->client->request('GET', '/api/trainingplan/user/99999999');
        $this->assertResponseIsSuccessful();

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertCount(2, $response);
        $this->assertEquals('Plan A', $response[0]['name']);
        $this->assertEquals('Plan B', $response[1]['name']);
    }
}
