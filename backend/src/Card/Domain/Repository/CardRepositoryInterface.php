<?php

namespace App\Card\Domain\Repository;

use App\Card\Domain\Entity\Card;
use App\Shared\Domain\Model\Uid;
use Symfony\Component\Uid\Uuid;

interface CardRepositoryInterface
{
    public function save(Card $card): void;

    public function findById(string $id): ?Card;

    public function findAllOrderedByPrice(?bool $bonusProgram = null, string $sortBy = 'name', string $order = 'asc'): array;

    public function remove(Card $card): void;
}
