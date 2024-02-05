<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function getAllLivresWithEmprunts(): array
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.emprunts', 'e')
            ->addSelect('e') // Sélectionnez également les emprunts
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult();
    }


    // Version historique
    // public function getAllLivresWithEmprunts(): array
    // {
    //     return $this->createQueryBuilder('l')
    //         ->leftJoin('l.emprunts', 'e', Join::WITH, 'e.enCours = false') // Inclure tous les emprunts, même ceux qui ont déjà été retournés
    //         ->orderBy('l.id', 'ASC')
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
