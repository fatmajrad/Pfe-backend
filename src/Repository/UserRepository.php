<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(User $entity, bool $flush = true): void
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
    public function remove(User $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function countAllUsers(string $statut): int
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT count(p)
            FROM App\Entity\User p
            WHERE p.statut = :statut'
         
        )->setParameter('statut', $statut);

        // returns an array of Product objects
        return $query->getSingleScalarResult();
    }

   

    public function countIntervallUsers(string $statut,$minDate,$maxDate){
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
            FROM App\Entity\User p
            WHERE p.createdAt = :createdAt
            AND p.statut = :statut'
        )->setParameters(array('createdAt'=> $createdAt, 'statut'=>$statut));
      
        return $query->getResult();
    }

    public function getAllUsers(){
        $entityManager = $this->getEntityManager();
        $nomUser="admin";
        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\User p
            WHERE p.nomUser <> :nomUser'
        )->setParameters(array('nomUser'=> $nomUser));
      
        return $query->getResult();
    }
}
