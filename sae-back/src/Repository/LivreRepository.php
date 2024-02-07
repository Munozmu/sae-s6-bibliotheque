<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 *
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    // public function getAllLivresWithEmprunts(): array
    // {
    //     return $this->createQueryBuilder('l')
    //         ->leftJoin('l.emprunts', 'e')
    //         ->addSelect('e') // Sélectionnez également les emprunts
    //         ->orderBy('l.id', 'ASC')
    //         ->getQuery()
    //         ->getResult();
    // }


    // Version historique
    public function getAllLivresWithEmprunts(): array
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.emprunts', 'e', Join::WITH, 'e.enCours = false')
            ->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function countAllEmprunts(): int
    {
        return $this->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getLivresNonEmpruntes(): array
    {
        return $this->createQueryBuilder('livre')
        ->leftJoin('livre.emprunts', 'emprunt')
        ->andWhere('emprunt.enCours = false OR emprunt.id IS NULL')
        ->select('livre.titre', 'livre.id')
        ->getQuery()
        ->getResult();
    }

    // public function getLivresNonDisponiblesAvecDateRetour(): array
    // {
    //     return $this->createQueryBuilder('livre')
    //         ->andWhere('livre.isAvailable = false')
    //         ->select('livre.titre', 'livre.emprunts.dateRetour')
    //         ->getQuery()
    //         ->getResult();
    // }

//    /**
    //     * @return Livre[] Returns an array of Livre objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

//    public function findOneBySomeField($value): ?Livre
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
