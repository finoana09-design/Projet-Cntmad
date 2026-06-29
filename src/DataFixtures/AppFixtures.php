<?php

namespace App\DataFixtures;

use App\Entity\Niveau;
use App\Entity\Filiere;
use App\Entity\Matiere;
use App\Entity\Student;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 5; $i++) {
            $filiere = new Filiere;
            $filiere->setFiliere($faker->company);

            $manager->persist($filiere);

            for ($j = 1; $j <= 5; $j++) {
                $niveau = new Niveau;
                $niveau->setNiveau($faker->firstName)
                    ->setFiliere($filiere);
                $manager->persist($niveau);

                for ($e = 1; $e <= 10; $e++) {
                    $matiere = new Matiere;
                    $matiere->setNameMatiere($faker->jobTitle)
                        ->setNiveau($niveau);
                    $manager->persist($matiere);
                }

                for ($k = 1; $k <= 10; $k++) {
                    $student = new Student;
                    $student->setName($faker->name)
                        ->setFirstname($faker->firstName)
                        ->setMatricule($faker->creditCardNumber)
                        ->setAdresse($faker->address)
                        ->setContact($faker->phoneNumber)
                        ->setGenre('male')
                        ->setNiveau($niveau);
                    $manager->persist($student);
                }
            }
        }

        $manager->flush();
    }
}
