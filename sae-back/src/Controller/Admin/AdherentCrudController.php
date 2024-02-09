<?php

namespace App\Controller\Admin;

use App\Entity\Adherent;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
            TextField::new('password')
                ->setFormType(RepeatedType::class)
                    ->setFormTypeOptions([
                        'type' => PasswordType::class,
                        'first_options' => [
                            'label' => 'Mot de passe',
                                'hash_property_path' => 'password',
                        ],
                        'second_options' => ['label' => 'Confirmer le mot de passe'],
                        'mapped' => false,
                    ])
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->onlyOnForms(),
            TextField::new('adressePostale'),
            TextField::new('numTel'),
            TextField::new('photo'),

            AssociationField::new('reservations'),
            AssociationField::new('emprunts'),        
        ];
    }
}
