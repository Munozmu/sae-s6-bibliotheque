<?php

namespace App\Repository;

use App\Entity\Adherent;
use App\Entity\Emprunt;
use App\Entity\Livre;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
/**
 * @extends ServiceEntityRepository<Emprunt>
 *
 * @method Emprunt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunt[]    findAll()
 * @method Emprunt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmpruntRepository extends ServiceEntityRepository
{
    private $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Emprunt::class);
        $this->em = $entityManager;
    }

    public function getAllEmprunts(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getLivresNonDisponiblesAvecDateRetour(): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.correspondre', 'livre')
            ->select('livre.titre', 'e.dateRetour')
            ->getQuery()
            ->getResult();
    }

    public function getActualEmprunts(): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.enCours = true')
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function retourEmprunt(Emprunt $emprunt): Void
    {
        if ($emprunt) {
            // Modifier l'état de l'emprunt
            $emprunt->setEnCours(false);

            // Mettre à jour la base de données
            $this->_em->flush();
        }
    }

    public function makeEmprunt(Adherent $adherent, Livre $livre, DateTime $dateDebut, DateTime $dateRetour): Void
    {
        $emprunt = new Emprunt();
        $emprunt->setAdherent($adherent);
        $emprunt->setCorrespondre($livre);
        $emprunt->setDateEmprunt($dateDebut);
        $emprunt->setDateRetour($dateRetour);

        // Persist et flush pour enregistrer les changements
        $entityManager = $this->getEntityManager();
        $entityManager->persist($emprunt);
        $entityManager->flush();
    }
}
