<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
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


    public function searchByParameter($keyword, $lang, $anneeMin, $anneeMax): array
    {
        // return $this->createQueryBuilder('l')
        //     ->andWhere("l.titre LIKE :keyword")
        //     ->andWhere("l.langue LIKE :lang")
        //     ->andWhere("l.dateSortie BETWEEN :anneeMin AND :anneeMax")
        //     ->setParameters([
        //         'keyword' => '%' . $keyword . '%',
        //         'lang' => '%' . $lang . '%',
        //         'anneeMin' => $anneeMin . '-01-01',
        //         'anneeMax' => $anneeMax . '-31-12'
        //     ])
        //     ->getQuery()
        //     ->getResult();

        // $entityManager = $this->getEntityManager();

        // $query = $entityManager->createQuery(
        //     "Select l
        //     From App\Entity\Livre l
        //     Where l.titre LIKE :keyword
        //     And l.langue LIKE :lang
        //     And l.dateSortie BETWEEN '2024-01-01' AND '2025-31-12'
        //     "
        // )->setParameters([
        //     'keyword' => '%' . $keyword . '%',
        //     'lang' => '%' . $lang . '%',
        //     'anneeMin' => '2024-01-01',
        //     'anneeMax' => '2025-31-12'
        // ]);

        // return $query->getResult();
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT *
            FROM livre
            WHERE livre.titre LIKE :keyword 
            AND livre.date_sortie BETWEEN :anneeMin AND :anneeMax 
            AND livre.langue LIKE :lang
        ";

        $resultSet = $conn->executeQuery($sql, [
            'keyword' => '%' . $keyword . '%',
            'lang' => '%' . $lang . '%',
            'anneeMin' => $anneeMin . '-01-01',
            'anneeMax' => $anneeMax . '-12-31',
        ]);

        return $resultSet->fetchAllAssociative();
    }

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
