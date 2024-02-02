<?php

namespace App\Controller\Admin;

use App\Entity\Adherent;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AdherentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adherent::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('dateAdhesion'),
            TextField::new('nom'),
            TextField::new('prenom'),
            DateField::new('dateNaiss'),
            TextField::new('email'),
            TextField::new('password'),
            TextField::new('adressePostale'),
            TextField::new('numTel'),
            TextField::new('photo'),

            AssociationField::new('reservations'),
            AssociationField::new('emprunts'),        
        ];
    }
}
