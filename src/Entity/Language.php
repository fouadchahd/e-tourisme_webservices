<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LanguageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=LanguageRepository::class)
 * @UniqueEntity("name",message="this language is already exist")
 */
class Language
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotNull(message="the language name should not be null")
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\Language(message="the language code should respect the Unicode language identifier as: fr,en,ar ")
     * @ORM\Column(type="string", length=10)
     */
    private $languageCode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLanguageCode(): ?string
    {
        return $this->languageCode;
    }

    public function setLanguageCode(string $languageCode): self
    {
        $this->languageCode = $languageCode;

        return $this;
    }
}
