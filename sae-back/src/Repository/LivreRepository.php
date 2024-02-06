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


    public function searchByParameter($keyword, $lang, $anneeMin, $anneeMax, $author, $category): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT livre.id AS livreId ,livre.titre,livre.date_sortie AS dateSortie,livre.langue,livre.photo_couverture,livre.resume,auteur.id AS auteurId,auteur.nom AS auteurNom , auteur.prenom AS auteurPrenom , categorie.id AS cate_id , categorie.nom AS cate_nom
            FROM livre , auteur , auteur_livre , livre_categorie, categorie
            WHERE auteur_livre.livre_id = livre.id
            AND auteur_livre.auteur_id = auteur.id
            AND livre_categorie.livre_id = livre.id
            AND livre_categorie.categorie_id = categorie.id
            AND livre.titre LIKE :keyword 
            AND livre.date_sortie BETWEEN :anneeMin AND :anneeMax 
            AND livre.langue LIKE :lang
            AND auteur.nom LIKE :auteur
            AND categorie.nom LIKE :categorie
        ";

        $resultSet = $conn->executeQuery($sql, [
            'keyword' => '%' . $keyword . '%',
            'lang' => '%' . $lang . '%',
            'anneeMin' => $anneeMin . '-01-01',
            'anneeMax' => $anneeMax . '-12-31',
            'auteur' => '%' . $author . '%',
            'categorie' => '%' . $category . '%'
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
