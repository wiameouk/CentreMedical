<?php

namespace App\Controller\Admin;

use App\Entity\Materiel;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MaterielCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Materiel::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            
            TextField::new('name' ,'Nom de materiel'),
            IntegerField::new('qte' ,'quantite du Materiel'),
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
                    ->setEntityLabelInPlural("Materiels")
                    ->setEntityLabelInSingular("Materiel")
                    ;
    }
    public function configureActions(Actions $actions):Actions
    {
        return $actions
                ->setPermission(Action::NEW, "ROLE_INFERMIERE")
                ->setPermission(Action::EDIT,"ROLE_INFERMIERE")
                ->setPermission(Action::DELETE,"ROLE_INFERMIERE")
                ;
    }
    
}
