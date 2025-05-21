<?php

namespace App\Card\Infrastructure\Repository\Doctrine;

use App\Card\Domain\Entity\Card;
use App\Card\Domain\Repository\CardRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class CardRepository implements CardRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->repository = $this->em->getRepository(Card::class);
    }

    public function save(Card $card): void
    {
        $this->em->persist($card);
        $this->em->flush();
    }

    public function findById(string $id): ?Card
    {
        return $this->repository->find($id);
    }

    public function findAllOrderedByPrice(?bool $bonusProgram = null, string $sortBy = 'name', string $order = 'asc'): array
    {

        $validSortFields = ['name', 'annualFee', 'transactionFee'];
        $validOrders = ['asc', 'desc'];


        if (!in_array($sortBy, $validSortFields)) {
            $sortBy = 'name';
        }

        if (!in_array($order, $validOrders)) {
            $order = 'asc';
        }

        $qb = $this->repository->createQueryBuilder('c')
            ->orderBy("c.$sortBy", $order);

        if ($bonusProgram !== null) {
            $this->bonusProgram($qb, $bonusProgram);
        }

        if ($sortBy === 'annualFee') {
            $qb->addOrderBy('c.transactionFee', $order);
        }

        return $qb->getQuery()->getResult();
    }

    public function bonusProgram($qb, bool $bonusProgram): void
    {
        $connection = $this->em->getConnection();

        // Comparamos con un string porque bonus_program está almacenado como "1" o "0"
        $sql = "SELECT id FROM card WHERE JSON_UNQUOTE(JSON_EXTRACT(features, '$.bonus_program')) = :bonusProgram";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue('bonusProgram', $bonusProgram ? '1' : '0', \PDO::PARAM_STR);
        $result = $stmt->executeQuery()->fetchAllAssociative();

        $ids = array_column($result, 'id');

        if (!empty($ids)) {
            $qb->andWhere('c.id IN (:ids)')
                ->setParameter('ids', $ids, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        } else {
            $qb->andWhere('1 = 0');
        }
    }


    public function remove(Card $card): void
    {
        $this->em->remove($card);
        $this->em->flush();
    }
}
