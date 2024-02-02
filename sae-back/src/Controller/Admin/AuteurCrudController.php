<?php

namespace App\Controller\Admin;

use App\Entity\Auteur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AuteurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Auteur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('prenom'),
            TextField::new('nom'),
            DateField::new('dateNaissance'),
            DateField::new('dateDeces'),
            TextField::new('nationalite'),  
            TextField::new('photo'),
            TextEditorField::new('description'),
            AssociationField::new('livres')
            ->formatValue(function ($value, $entity) {
                // Personnalisez la façon dont les catégories sont affichées dans la liste
                $livres = $entity->getLivres();

                $livresList = [];
                foreach ($livres as $livres) {
                    $livresList[] = $livres->getTitre();
                }

                return implode(', ', $livresList);
            }),
        ];
    }
}
