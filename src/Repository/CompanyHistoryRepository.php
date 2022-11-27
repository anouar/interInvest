<?php

namespace App\Repository;

use App\Entity\CompanyHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyHistory>
 *
 * @method CompanyHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyHistory[]    findAll()
 * @method CompanyHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyHistory::class);
    }

    public function save(CompanyHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CompanyHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function getHistoryCompanyByDate($date): array
    {
        return $this->createQueryBuilder('hc')
            ->andWhere('hc.createdAt <= :date')
            ->setParameter('date', $date)
            ->orderBy('hc.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
