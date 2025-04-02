<?php

namespace App\Tests\Utils;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManagerInterface;

abstract class TransactionalTestCase extends WebTestCase
{
    protected EntityManagerInterface $em;

    protected function setUp(): void
    {
        // NICHT bootKernel() – nur createClient
        static::createClient();
        $this->em = static::getContainer()->get(EntityManagerInterface::class);
        $this->em->getConnection()->beginTransaction();
    }

    protected function tearDown(): void
    {
        if ($this->em->getConnection()->isTransactionActive()) {
            $this->em->getConnection()->rollBack();
        }

        parent::tearDown();
    }
}