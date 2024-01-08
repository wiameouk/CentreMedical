<?php

namespace App\Controller\Admin;

use App\Entity\Personel;
use phpDocumentor\Reflection\Types\Integer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PersonelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Personel::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('First_Name','Nom'),
            TextField::new('Last_Name','Prenom'),
            TextField::new('Poste','Poste'),
            TextField::new('Adresse','Adresse'),
            TextField::new('phone','phone'),
            DateTimeField::new('Date_Naissance', 'Date de naissance'),
            FormField::addPanel('creation et Modification:')
                ->collapsible()
                ->hideOnForm(),
            DateTimeField::new('CreatedAt')
                ->hideOnForm(),
            DateTimeField::new('UpdatedAt')
                ->hideOnForm(),

        ];
    }
    public function configureCrud(Crud $crud):Crud
    {
        return $crud
            ->setEntityLabelInPlural("Personels")
            ->setEntityLabelInSingular("Personel")
        ;
    }
    public function configureActions(Actions $actions):Actions
    {
        return $actions
            ->setPermission(Action::NEW, "ROLE_RH")
            ->setPermission(Action::EDIT,"ROLE_RH")
            ->setPermission(Action::DELETE,"ROLE_RH")
            ;
    }
    
}
