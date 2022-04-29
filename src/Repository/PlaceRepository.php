<?php

namespace App\Repository;

use App\Entity\Place;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Place|null find($id, $lockMode = null, $lockVersion = null)
 * @method Place|null findOneBy(array $criteria, array $orderBy = null)
 * @method Place[]    findAll()
 * @method Place[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Place::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Place $entity, bool $flush = true): void
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
    public function remove(Place $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    
     /**
     * @return Place[]
     */
    public function findPlanBySujet($sujet){
        return $this->createQueryBuilder('Place')
            ->andWhere('Place.PostalCode LIKE :sujet or Place.Name LIKE :sujet')
            ->setParameter('sujet', '%'.$sujet.'%')
            ->getQuery()
            ->getResult();
    }
    
    public function updatePlaceStatus($id)
    {
        return $this->createQueryBuilder('p')
            ->update()
            ->set('p.Status', 1)
            ->where('p.id = ?1')
            ->setParameter(1, $id)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
    public function findPlaceByType($type){

        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT DISTINCT  count(p.Type) FROM   App\Entity\Place p  where p.Type = :typee   '
        );
        $query->setParameter('typee', $type);
        return $query->getResult();
    }
    public function findPlaceByStatus($type){

        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT DISTINCT  count(p.Status) FROM   App\Entity\Place p  where p.Status = :typee   '
        );
        $query->setParameter('typee', $type);
        return $query->getResult();
    }
   
         
    // /**
    //  * @return Place[] Returns an array of Place objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Place
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
