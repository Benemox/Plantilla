<?php

namespace App\Tests\Unit\Card\Infrastructure\Controller;

use App\Card\Domain\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ListCardsTest extends WebTestCase
{
    private EntityManagerInterface $entityManager;
    private $client;

    protected function setUp(): void
    {
        self::ensureKernelShutdown();
        $this->client = static::createClient();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $this->entityManager->createQuery('DELETE FROM App\Card\Domain\Entity\Card')->execute();

        $this->createTestCards();
    }

    private function createTestCards(): void
    {
        $card1 = new Card(
            1,
            'Gold Card',
            'Bank A',
            ['bonus_program' => 'cashback'],
            '100.00',
            '10.00',
            'credit',
            'https://example.com/gold.jpg',
            'https://example.com/gold'
        );

        $card2 = new Card(
            2,
            'Silver Card',
            'Bank B',
            ['bonus_program' => 'travel'],
            '50.00',
            '5.00',
            'debit',
            'https://example.com/silver.jpg',
            'https://example.com/silver'
        );

        $this->entityManager->persist($card1);
        $this->entityManager->persist($card2);
        $this->entityManager->flush();
    }

    public function testListCards(): void
    {
        $this->client->request('GET', '/api/v1/cards');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $responseData = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertCount(2, $responseData);
        $this->assertEquals('Gold Card', $responseData[0]['name']);
        $this->assertEquals('Silver Card', $responseData[1]['name']);
    }


    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->createQuery('DELETE FROM App\Card\Domain\Entity\Card')->execute();
        $this->entityManager->close();
    }
}
