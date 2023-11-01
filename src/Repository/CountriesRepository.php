<?php

namespace App\Repository;

use App\Entity\Countries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Countries>
 *
 * @method Countries|null find($id, $lockMode = null, $lockVersion = null)
 * @method Countries|null findOneBy(array $criteria, array $orderBy = null)
 * @method Countries[]    findAll()
 * @method Countries[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Countries::class);
    }

    // public function filterCountriesByPosts(int $country_id) : array
    // {
    //     return $this->createQueryBuilder('i')
    //                 ->innerJoin('i.countries', 'i')
    //                 ->select('c')
    //                 ->where('i.id = :id')
    //                 ->setParameter('id',  $country_id)
    //                 ->setParameter('val', true)
    //                 ->orderBy('p.country', "ASC")
    //                 ->getQuery()
    //                 ->getOneOrNullResult();
    // }

    public function filterCountriesByPosts()
    {
        $qb = $this->createQueryBuilder('c');
        
        $qb->innerJoin('c.posts', 'p')
            ->where("p.isPublished = 1")
            ->orderBy('p.publishedAt', "DESC")
            ->distinct()
            ->select('c')
            ->setMaxResults(3);

        return $qb->getQuery()->getResult();

    }

//    /**
//     * @return Countries[] Returns an array of Countries objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Countries
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
