<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\Date;

class LivreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Livre::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            TextField::new('langue'),
            DateField::new('dateSortie'),
            TextField::new('photoCouverture'),
            AssociationField::new('categories')
            ->formatValue(function ($value, $entity) {
                // Personnalisez la façon dont les catégories sont affichées dans la liste
                $categories = $entity->getCategories();

                $categoriesList = [];
                foreach ($categories as $categorie) {
                    $categoriesList[] = $categorie->getNom();
                }

                return implode(', ', $categoriesList);
            }),
            AssociationField::new('auteurs')
                ->formatValue(function ($value, $entity) {
                    // Personnalisez la façon dont les auteurs sont affichés dans la liste
                    $auteurs = $entity->getAuteurs();
                    $auteursList = [];
                    foreach ($auteurs as $auteur) {
                        $auteursList[] = $auteur->getPrenom(). ' ' .$auteur->getNom(); // Ajoutez le nom complet de l'auteur
                    }

                    return implode(', ', $auteursList);
                }),
        ];
    }
}
