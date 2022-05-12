<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\GroupBy;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Question $entity, bool $flush = true): void
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
    public function remove(Question $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Question[] Returns an array of Question objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Question
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function countAllQuestions(string $statut): int
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT count(p)
            FROM App\Entity\Question p
            WHERE p.statut = :statut'
         
        )->setParameter('statut', $statut);

        // returns an array of Product objects
        return $query->getSingleScalarResult();
    }

   

    public function countIntervallQuestions(string $statut,$minDate,$maxDate){
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
            FROM App\Entity\Question p
            WHERE p.createdAt = :createdAt
            AND p.statut = :statut'
        )->setParameters(array('createdAt'=> $createdAt, 'statut'=>$statut));
      
        return $query->getResult();
    }

   public function getRecentQuestions(){
    $statut="valide";
    $entityManager = $this->getEntityManager();
    $query = $entityManager->createQuery(
        'SELECT p 
         FROM App\Entity\Question p
         WHERE p.statut= :statut
         ORDER BY p.createdAt DESC'
    )->setParameter('statut', $statut);
    return $query->getResult();
  }
 
  public function findById($id){
    $entityManager = $this->getEntityManager();
    $query = $entityManager->createQuery(
        'SELECT p 
         FROM App\Entity\Question p
         WHERE p.id = :id
         ORDER BY p.createdAt DESC'
    )->setParameter('id', $id);
    return $query->getResult();
  }
  
}
