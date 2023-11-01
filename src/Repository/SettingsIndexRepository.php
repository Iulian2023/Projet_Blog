<?php

namespace App\Repository;

use App\Entity\SettingsIndex;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SettingsIndex>
 *
 * @method SettingsIndex|null find($id, $lockMode = null, $lockVersion = null)
 * @method SettingsIndex|null findOneBy(array $criteria, array $orderBy = null)
 * @method SettingsIndex[]    findAll()
 * @method SettingsIndex[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingsIndexRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingsIndex::class);
    }

//    /**
//     * @return SettingsIndex[] Returns an array of SettingsIndex objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SettingsIndex
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
