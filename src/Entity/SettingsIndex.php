<?php

namespace App\Entity;

use App\Repository\SettingsIndexRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: SettingsIndexRepository::class)]
class SettingsIndex
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Le titre est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le titre ne doit pas dépasser {{ limit }} caractéres',
    )]
    #[ORM\Column(length: 255)]
    private ?string $titleHeader = null;

    #[Assert\NotBlank(message: "Le text est obligatoire.")]
    #[Assert\Length(
        max: 900,
        maxMessage: 'Le text ne doit pas dépasser {{ limit }} caractéres',
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $textHeader = null;

    #[Assert\NotBlank(message: "Le text est obligatoire.")]
    #[Assert\Length(
        max: 800,
        maxMessage: 'Le text ne doit pas dépasser {{ limit }} caractéres',
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $firstTextAboutMe = null;

    #[Assert\NotBlank(message: "Le text est obligatoire.")]
    #[Assert\Length(
        max: 800,
        maxMessage: 'Le text ne doit pas dépasser {{ limit }} caractéres',
    )]

    #[ORM\Column(type: Types::TEXT)]
    private ?string $secondTextAboutMe = null;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleHeader(): ?string
    {
        return $this->titleHeader;
    }

    public function setTitleHeader(string $titleHeader): static
    {
        $this->titleHeader = $titleHeader;

        return $this;
    }

    public function getTextHeader(): ?string
    {
        return $this->textHeader;
    }

    public function setTextHeader(string $textHeader): static
    {
        $this->textHeader = $textHeader;

        return $this;
    }

    public function getFirstTextAboutMe(): ?string
    {
        return $this->firstTextAboutMe;
    }

    public function setFirstTextAboutMe(string $firstTextAboutMe): static
    {
        $this->firstTextAboutMe = $firstTextAboutMe;

        return $this;
    }

    public function getSecondTextAboutMe(): ?string
    {
        return $this->secondTextAboutMe;
    }

    public function setSecondTextAboutMe(string $secondTextAboutMe): static
    {
        $this->secondTextAboutMe = $secondTextAboutMe;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
