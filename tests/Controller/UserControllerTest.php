<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\Utils\TransactionalTestCase;

class UserControllerTest extends TransactionalTestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::getClient();
    }

    public function testCreateUser(): void
    {
        $this->client->request('POST', '/api/users', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'name' => 'Test User',
            'mail' => 'testuser@example.com',
            'password' => 'testpass123',
        ]));

        $this->assertResponseStatusCodeSame(201);

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('User created successfully', $responseData['message']);
        $this->assertArrayHasKey('id', $responseData);

        $user = $this->em->getRepository(User::class)->findOneBy([
            'mail' => 'testuser@example.com',
        ]);

        $this->assertNotNull($user);
        $this->assertEquals('Test User', $user->getName());
    }

    public function testGetNonexistentUser(): void
    {
        $this->client->request('GET', '/api/users/999999');

        $this->assertResponseStatusCodeSame(404);

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('User not found', $responseData['message']);
    }

    public function testLoginWithCorrectCredentials(): void
    {
        $user = new User();
        $user->setName('Login Test');
        $user->setMail('login@example.com');
        $user->setPassword(password_hash('secret123', PASSWORD_DEFAULT));
        $this->em->persist($user);
        $this->em->flush();

        $this->client->request('POST', '/api/users/login', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'mail' => 'login@example.com',
            'password' => 'secret123',
        ]));

        $this->assertResponseIsSuccessful();

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('valid Credentials', $responseData['message']);
        $this->assertEquals('Login Test', $responseData['name']);
    }
}
