<?php

namespace App\Repository;

use App\Entity\Equipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use App\Data\SearchData;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Equipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Equipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equipe[]    findAll()
 * @method Equipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipe::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Equipe $entity, bool $flush = true): void
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
    public function remove(Equipe $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /** 
     *@return User[]
     */
    public function findSearch(SearchData $search): array
    {
        $query = $this->createQueryBuilder('u')->select('u');



        if ($search->q || $search->p) {
            $query =
                $query
                ->where('u.nomEquipe LIKE :q')
                ->setParameter('q', '%' . $search->q . '%')
                ->andWhere('u.IdResponsable LIKE :p')
                ->setParameter('p', '%' . $search->p . '%');
        }




        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Equipe[] Returns an array of Equipe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Equipe
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    //  /**
    //  * @return Equipe[] Returns an array of Utilisateur objects
    //  */

    // public function findByNomEquipe($value)
    // {
    //     return $this->createQueryBuilder('u')
    //         ->andWhere('u.nom_equipe = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getResult();
    // }

    public function findByNomEquipe($name){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("SELECT * FROM APP\Entity\Equipe s  WHERE s.nomEquipe like :name ")
            ->setParameter('name',$name);
            return $query->getSingleScalarResult();
    }

}
