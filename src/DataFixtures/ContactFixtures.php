<?php

namespace App\DataFixtures;

use App\Entity\SettingsContact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $setting = $this->DefaultContactParametres();

        $manager->persist($setting);

        $manager->flush();
    }

    private function DefaultContactParametres() : SettingsContact
    {
        $settingsContact = new SettingsContact();

        $settingsContact->setEmail('jules.rousseau@jusquauboutdumonde.com');
        $settingsContact->setPhone('06 12 34 56 78');
        $settingsContact->setTiktok('https://www.tiktok.com/');
        $settingsContact->setYoutube('https://www.youtube.com/?hl=fr&gl=FR');
        $settingsContact->setInstagram('https://www.instagram.com/');

        return $settingsContact;

    }
}
