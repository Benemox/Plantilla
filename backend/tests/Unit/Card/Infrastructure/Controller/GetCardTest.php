<?php

namespace App\Tests\Unit\Card\Infrastructure\Controller;

use App\Card\Domain\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetCardTest extends WebTestCase
{
    private EntityManagerInterface $entityManager;

    private KernelBrowser $client;


    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $this->entityManager->createQuery('DELETE FROM App\Card\Domain\Entity\Card')->execute();
        $this->entityManager->flush();
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->createQuery('DELETE FROM App\Card\Domain\Entity\Card')->execute();
        $this->entityManager->clear();
    }


    private function createTestCard(): Card
    {
        $card = new Card(
            1,
            'Test Card',
            'Test Bank',
            ['bonus_program' => '1'],
            '10.00',
            '5.00',
            'credit',
            'https://example.com/logo.jpg',
            'https://example.com/link'
        );

        $this->entityManager->persist($card);
        $this->entityManager->flush();

        return $card;
    }


    public function testGetCardById(): void
    {
        $card = $this->createTestCard();

        $this->client->request('GET', '/api/v1/cards/' . $card->getId());


        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($card->getId(), $responseData['id']);
        $this->assertEquals($card->getName(), $responseData['name']);
    }
}
