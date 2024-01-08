<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WelcomeController extends AbstractController
{
    #[Route('/', name: 'welcome.index')]
    public function index(): Response
    {
        return $this->render('welcome/index.html.twig', [
        ]);
    }
    #[Route('/contact', name: 'welcome.contact')]
    public function contact(Request $request, EntityManagerInterface $manager): Response
    {
        $contact = new Contact();
        
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $contact = $form->getData();
            $manager->persist($contact);
            $manager->flush();

            return $this->redirectToRoute("welcome.index");
        }
        

        return $this->render('welcome/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
