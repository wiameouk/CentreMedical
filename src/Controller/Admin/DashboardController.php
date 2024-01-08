<?php

namespace App\Controller\Admin;

use App\Entity\Personel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;


class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'security.admin')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ACCESS');
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('security/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('CentreMedical')
            ->renderContentMaximized()
                ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section("User");
        yield MenuItem::linkToCrud('Admin', 'fa-solid fa-user', User::class)
            ->setController(AdminCrudController::class)
            ->setPermission("ROLE_ADMIN");
        yield MenuItem::linkToCrud('Medecin','fas fa-user-md', User::class)
            ->setController(MedecinCrudController::class)
            ->setPermission("ROLE_RH");
        yield MenuItem::linkToCrud('Infirmiere', 'fa-solid fa-user-nurse', User::class)
            ->setController(InfirmiereCrudController::class)
            ->setPermission("ROLE_MEDECIN");
        yield MenuItem::linkToCrud('Rh', 'fas fa-users', User::class)
            ->setController(RhCrudController::class)
            ->setPermission("ROLE_ADMIN");

        yield MenuItem::section("Meteriel et salle");
        yield MenuItem::linkToCrud('Salle', 'fas fa-hospital', Salle::class)
            ->setController(SalleCrudController::class);

        yield MenuItem::linkToCrud('Materiel', 'fas fa-cog', Materiel::class)
            ->setController(MaterielCrudController::class);
        yield MenuItem::section("Personel et Patient");

        yield MenuItem::linkToCrud('Personel', 'fa-solid fa-user', Personel::class)
            ->setController(PersonelCrudController::class); 
        yield MenuItem::linkToCrud('Patient', 'fa-solid fa-user', Patient::class)
            ->setController(PatientCrudController::class); 
        yield MenuItem::section("Contact");
        yield MenuItem::linkToCrud('Contact', 'fa-solid fa-phone', Contact::class)
            ->setController(ContactCrudController::class);
        yield MenuItem::section("Useful Links");
        yield MenuItem::linkToRoute("Visite Website",'fas fa-hospital',"welcome.index",[]);
        yield MenuItem::linkToLogout("Logout", 'fa-solid fa-user');
    }

    public function configureCrud():Crud
    {
        return Crud::new()
                ->setPaginatorPageSize(6)
                ->setPaginatorRangeSize(0)
                ->renderContentMaximized()
                ->setDateFormat("medium")    
            ;

    }
    public function configureActions():Actions
    {
        $action=parent::configureActions();
        $action->add(Crud::PAGE_INDEX,Action::DETAIL);
        return $action;
    }
}
