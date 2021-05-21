<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(normalizationContext={"skip_null_values"=false})
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 */
class Photo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"city:read"})
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="The url field should not be null.")
     * @Assert\NotBlank(message="The url field should not be blank.")
     * @Groups({"poi:write","poi_item:read","tourist:write","city:write","city:read"})
     */
    private $url;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"poi:write","poi_item:read","city:write","city:read"})
     */
    private $alt;

    /**
     * @ORM\ManyToOne(targetEntity=Poi::class, inversedBy="photo")
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

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): self
    {
        $this->alt = $alt;

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
