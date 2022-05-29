<?php

namespace App\DataFixtures;

use App\Entity\Exercise;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($l = 0; $l < 3; $l++) {
            for ($p = 0; $p < 3; $p++) {
                for ($i = 0; $i < 100; $i++) {

                    $e = new Exercise();
                    $e->setLvl($l);
                    $e->setPart($p);
                    $n = $this->generateRandomString();
                    $e->setName(sprintf('Exercise %s (level %d, part %d)', $n, $l, $p));
                    $manager->persist($e);
                }

                $manager->flush();
            }
        }
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
