<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DescriptionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=DescriptionRepository::class)
 */
class Description
{#content_languageIRI_poiIRI
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     * @Groups({"poi:write","poi_item:read"})
     */
    private $content;

    /**
     * @Assert\NotNull
     * @ORM\ManyToOne(targetEntity=Language::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"poi:write","poi_item:read"})
     */
    private $language;

    /**
     * @Assert\NotNull
     * @ORM\ManyToOne(targetEntity=Poi::class, inversedBy="description")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poi;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getPoi(): ?Poi
    {
        return $this->poi;
    }

    public function setPoi(?Poi $poi): self
    {
        $this->poi = $poi;

        return $this;
    }
}
