<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MedecinCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        $this->denyAccessUnlessGranted('ROLE_ACCESS');
        $this->denyAccessUnlessGranted('ROLE_RH');
        return [
            
            TextField::new('FirstName','Nom'),
            TextField::new('LastName','Prenom'),
            TextField::new('Phone','Numero de telephone'),
            TextField::new('specialite','specialite'),
            EmailField::new('email','Adresse Mail'),
            TextField::new('Adresse','Adresse'),
            DateTimeField::new('DateNaissance', 'Date de naissance'),
            FormField::addPanel('creation et Modification:')
                ->collapsible()
                ->hideOnForm(),
            DateTimeField::new('CreatedAt')
                ->hideOnForm(),
            DateTimeField::new('UpdatedAt')
                ->hideOnForm(),

        ];
    }
   
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto , FieldCollection $fieldCollection , FilterCollection $filterCollection): QueryBuilder{
        
    
        $querybuilder=parent::createIndexQueryBuilder($searchDto ,$entityDto ,$fieldCollection ,$filterCollection);
        $querybuilder->andWhere("entity.roles LIKE '%ROLE_MEDECIN%'");
        return $querybuilder;
    }
    public function configureCrud(Crud $crud):Crud
    {
        return $crud
                    ->setEntityLabelInPlural("Medecins")
                    ->setEntityLabelInSingular("Medecin")
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

