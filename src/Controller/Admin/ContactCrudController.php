<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

   
    public function configureFields(string $pageName): iterable
    {
        $this->denyAccessUnlessGranted('ROLE_ACCESS');
        
        return [
            
            TextField::new('Fullname'),
            EmailField::new('email','Adresse Mail'),
            TextField::new('Adresse','Adresse'),
            TextEditorField::new('description'),
            FormField::addPanel('creation :')
                ->collapsible()->hideOnForm(),
                DateTimeField::new('CreatedAt')
                ->hideOnForm(),
        ];
    }
    public function configureCrud(Crud $crud):Crud
    {
        return $crud
                    ->setEntityLabelInPlural("Contacts")
                    ->setEntityLabelInSingular("Contact")
                    ;
    }

    public function configureActions(Actions $actions):Actions 
    {
        return $actions
                    ->remove(Crud::PAGE_INDEX,Action::EDIT)
                    ->remove(Crud::PAGE_DETAIL,Action::EDIT)
                    ->remove(Crud::PAGE_INDEX,Action::NEW)
                     ;
    }
    
}
