<?php

namespace App\Repository;

use App\Entity\SettingsContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SettingsContact>
 *
 * @method SettingsContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method SettingsContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method SettingsContact[]    findAll()
 * @method SettingsContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingsContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingsContact::class);
    }

//    /**
//     * @return SettingsContact[] Returns an array of SettingsContact objects
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

//    public function findOneBySomeField($value): ?SettingsContact
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
