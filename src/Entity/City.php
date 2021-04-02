<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     denormalizationContext={"groups"={"city:write"}},
 *     normalizationContext={"skip_null_values"=false,"groups"={"city:read"}})
 * @ORM\Entity(repositoryClass=CityRepository::class)
 * @UniqueEntity("name",message="this city name is already used")
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"poi:write","poi_item:read","city:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,unique=true)
     * @Groups({"poi_item:read","city:write","city:read"})
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Photo::class, cascade={"persist", "remove"})
     * @Groups({"city:write","city:read"})
     */
    private $photo;

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

    public function getPhoto(): ?Photo
    {
        return $this->photo;
    }

    public function setPhoto(?Photo $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}
