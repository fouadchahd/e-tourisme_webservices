<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AudioRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=AudioRepository::class)
 */
class Audio
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"poi:write","poi_item:read"})
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"poi:write","poi_item:read"})
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity=Poi::class, inversedBy="audio")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poi;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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
