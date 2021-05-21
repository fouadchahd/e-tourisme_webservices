<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"poi:write","poi_item:read"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $formattedAddress;

    /**
     * @Groups({"poi:write","poi_item:read"})
     * @Assert\NotNull(message="latitude propertie should not be null")
     * @Assert\NotBlank()
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @Groups({"poi:write","poi_item:read"})
     * @Assert\NotNull(message="longitude propertie should not be null")
     * @Assert\NotBlank()
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @Groups({"poi:write","poi_item:read"})
     * @ORM\ManyToOne(targetEntity=City::class,cascade={"persist"})
     */
    private $city;


    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getFormattedAddress(): ?string
    {
        return $this->formattedAddress;
    }

    public function setFormattedAddress(?string $formattedAddress): self
    {
        $this->formattedAddress = $formattedAddress;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

}
