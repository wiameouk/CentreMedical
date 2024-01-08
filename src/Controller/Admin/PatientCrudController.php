<?php

namespace App\Controller\Admin;

use App\Entity\Patient;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PatientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Patient::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        $this->denyAccessUnlessGranted("ROLE_ACCESS");
        
        return [

            TextField::new('FirstName','Nom'),
            TextField::new('LastName','Prenom'),
            TextField::new('phone','Numero de telephone'),
            TextField::new('Adresse','Adresse'),
            IntegerField::new('Age','Age'),
            TextField::new('Description','Description'),
            TextField::new('Fiche_patient','Fiche_patient'),
            DateTimeField::new('Date_Naissance', 'Date de naissance'),
            FormField::addPanel('creation et Modification:')
               ->collapsible(),
            DateTimeField::new('CreatedAt'),
            DateTimeField::new('UpdatedAt'),
            
            
        ];
    }
    public function configureCrud(Crud $crud):Crud
    {
        return $crud
                    ->setEntityLabelInPlural("Patients")
                    ->setEntityLabelInSingular("Patient")
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
