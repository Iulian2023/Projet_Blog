<?php

namespace App\DataFixtures;

use App\Entity\SettingsIndex;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class IndexFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $setting = $this->DefaultIndexParameters();

        $manager->persist($setting);

        $manager->flush();
    }

    private function DefaultIndexParameters() : SettingsIndex
    {
        $settingIndex = new SettingsIndex();

        $settingIndex->setTitleHeader('Explorateur du Monde');
        $settingIndex->setTextHeader("Bienvenue sur 'Jusqu'au Bout du Monde', le portail qui vous emmène au cœur de l'aventure, de la découverte et de l'exploration. Je suis ravi de vous accueillir dans mon univers d'explorateur du monde, un endroit où chaque recoin de la planète devient une opportunité de voyage, d'apprentissage et d'émerveillement. Mon nom est Jules Rousseau, et ma vie est dédiée à l'exploration des merveilles naturelles, des cultures fascinantes et des paysages époustouflants qui composent notre planète. À travers ce blog, je souhaite vous emmener dans un voyage inspirant, vous faisant découvrir des destinations lointaines, des récits de voyage captivants et des réflexions sur l'importance de préserver notre environnement. Préparez-vous à vous immerger dans des aventures palpitantes et à être inspirés par la beauté du monde qui nous entoure.");
        $settingIndex->setFirstTextAboutMe("Je suis un explorateur passionné, écrivain et aventurier intrépide qui a consacré sa vie à parcourir les coins les plus reculés de notre planète. Mon désir inextinguible d'explorer le monde m'a conduit à des aventures fascinantes, des jungles mystérieuses aux sommets enneigés des montagnes les plus élevées. Au fil des années, j'ai collecté des récits inoubliables, des observations éclairantes et des rencontres incroyables, que je partage à travers les pages de ce blog, 'Jusqu'au Bout du Monde'. Mon but est de vous inspirer à explorer, à repousser vos limites et à embrasser la beauté de notre monde diversifié.");
        $settingIndex->setSecondTextAboutMe("Au-delà de l'exploration, ma passion s'étend à la rédaction, à la photographie et à la sensibilisation environnementale. Je crois en la puissance des mots et des images pour éveiller la curiosité et encourager la préservation de notre planète. En parcourant ce blog, vous découvrirez des récits captivants de voyages, des astuces pour les aventuriers en herbe, des analyses approfondies de questions environnementales et des réflexions personnelles sur la beauté et la fragilité de notre monde. Rejoignez-moi dans cette aventure et ensemble, nous irons 'Jusqu'au Bout du Monde' pour découvrir ce que notre planète a de plus beau et de plus précieux à offrir.");

        return $settingIndex;

    }
}


