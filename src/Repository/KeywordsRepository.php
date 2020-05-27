<?php

namespace App\Repository;

use App\Entity\Keywords;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Keywords|null find($id, $lockMode = null, $lockVersion = null)
 * @method Keywords|null findOneBy(array $criteria, array $orderBy = null)
 * @method Keywords[]    findAll()
 * @method Keywords[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeywordsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Keywords::class);
    }

    public function getKeywordsArray()
    {
        $resArr = [];

        $res = $this->createQueryBuilder('k')
            ->select('k.keyword')
            ->getQuery()
            ->execute();

        foreach ($res as $val) {
            array_push($resArr, $val['keyword']);
        }
        return $resArr;
    }

    /*
    public function findOneBySomeField($value): ?Keywords
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
