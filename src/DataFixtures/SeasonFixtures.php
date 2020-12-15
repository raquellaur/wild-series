<?php

namespace App\DataFixtures;

use App\Service\Slugify;
use Faker;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $season = new Season();
            $season->setNumber($faker->randomDigitNotNull);
            $season->setYear($faker->year($max = 'now'));
            $season->setDescription($faker->paragraph(5, true));
            $season->setProgram($this->getReference('program_' . rand(0,5)));
            $this->addReference('season_'. $i, $season);
            $manager->persist($season);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}