<?php

namespace App\Repository;

use App\Entity\LegalStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LegalStatus>
 *
 * @method LegalStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method LegalStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method LegalStatus[]    findAll()
 * @method LegalStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LegalStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LegalStatus::class);
    }

    public function save(LegalStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LegalStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
