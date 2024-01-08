<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Salle;
use App\Entity\Contact;
use App\Entity\Patient;
use App\Entity\Materiel;
use App\Entity\Personel;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $Roles = ["ROLE_MEDECIN", "ROLE_RH", "ROLE_INFERMIERE", "ROLE_ADMIN"];

        for ($i = 0; $i < 60; $i++) {
            $user = new User();
            $user->setEmail($faker->email())
                ->setPlainPassword("wiame")
                ->setFirstName($faker->firstName())
                ->setLastname($faker->lastName())
                ->setAdresse($faker->address())
                ->setPhone($faker->phoneNumber())
                ->setDatenaissance(new \DateTimeImmutable($faker->date()));
        
            $roleIndex = mt_rand(0, count($Roles) - 1);
            $role = $Roles[$roleIndex];
            $user->setRoles([$role]);
        
            if ($role == 'ROLE_MEDECIN') {
                $user->setSpecialite($faker->word());
                $medecin[] = $user;
            } else {
                $user->setSpecialite(null);
            }
        
            $manager->persist($user);
        }
        

        $SallesType = ["operation", "consultation", "attente", "bureaux", "chambre"];
        for($i=0; $i<60;$i++)
        {
            $salle=new Salle(); 
            $type = $SallesType[mt_rand(0, count($SallesType) - 1)];
            $salle->setType($type)
                ->setIsDisponible($faker->boolean())
            ;
            if($type === 'bureaux')
            {
                $owner = $medecin[mt_rand(0,count($medecin)-1)];
                if($owner->getSalle() === null)
                {
                   $salle->addOwner($owner); 
                }
            }
            $manager->persist($salle);

            $materiel = new Materiel();
            $materiel->setName($faker->name())
                ->setQte(mt_rand(0, 1000));
            $manager->persist($materiel);

            $contact = new Contact();
            $contact->setFullname($faker->name())
                ->setAdresse($faker->address())
                ->setEmail($faker->email())
                ->setDescription($faker->text())
            ;
            $manager->persist($contact);


        }
        $poste=["Secretaire","Visiteur","Agent_securite"];
        for($i=0;$i<60 ;$i++)
        {
            $patient =new Patient();
            $patient->setFirstName($faker->firstName())
                    ->setLastName($faker->lastName())
                    ->setAge(mt_rand(16,80))
                    ->setDescription($faker->text())
                    ->setDateNaissance(new \DateTimeImmutable($faker->date()))
                    ->setFichePatient($faker->text())
                    ->setPhone($faker->phoneNumber())
                    ->setAdresse($faker->address())

            ;
            $manager->persist($patient);
            $personel=new Personel();
                     $poste_personel=$poste[mt_rand(0, count($poste) - 1)];
                     $personel->setPoste($poste_personel)
                     ->setFirstName($faker->firstName())
                     ->setLastName($faker->lastName())
                     ->setDateNaissance(new \DateTimeImmutable($faker->date()))
                     ->setAdresse($faker->address())
                     ->setPhone($faker->phoneNumber())
                     ; 
            $manager->persist($personel);
        }


        $manager->flush();
    }
}
