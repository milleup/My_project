<?php

namespace App\Repository;

use App\Entity\Sale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sale|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sale|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sale[]    findAll()
 * @method Sale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sale::class);
    }

    // /**
    //  * @return Sale[] Returns an array of Sale objects
    //  */

    public function findByDateField($value1, $value2)
    {
            $sb = $this->createQueryBuilder('s')
            ->Where('(s.sale_date)->format(\'Y\') = :value1')
            ->andWhere('(s.sale_date)->format(\'m\') = :value2')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->orderBy('s.val2', 'ASC');
            $querysale = $sb->getQuery();
            return $querysale->execute();
    }


    // /**
    //  * @return Department[] Returns an array of Department objects
    //  */
  /*  public function findByExampleField(Request $value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }*/



    /*
    public function findOneBySomeField($value): ?Sale
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
