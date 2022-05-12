<?php

namespace App\Repository;

use App\Entity\Connaissance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Connaissance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Connaissance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Connaissance[]    findAll()
 * @method Connaissance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConnaissanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Connaissance::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Connaissance $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Connaissance $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Connaissance[] Returns an array of Connaissance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Connaissance
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function countAllConnaissances(string $statut): int
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT count(p)
            FROM App\Entity\Connaissance p
            WHERE p.statut = :statut'
         
        )->setParameter('statut', $statut);

        // returns an array of Product objects
        return $query->getSingleScalarResult();
    }

   

    public function countIntervallConnaissances(string $statut,$minDate,$maxDate){
        $tab=[];
        for ($i=$minDate; $i <=$maxDate ; $i++) { 
            $x=["total" =>$this->getDateTotal($i,$statut)[0]["total"]] ;
            $x+=["createdAt"=>$i];
            array_push($tab, $x);
        }
        return $tab;
    }

    public function getDateTotal($createdAt,$statut){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT count(p) AS total
            FROM App\Entity\Connaissance p
            WHERE p.createdAt = :createdAt
            AND p.statut = :statut'
        )->setParameters(array('createdAt'=> $createdAt, 'statut'=>$statut));
      
        return $query->getResult();
    }
}
