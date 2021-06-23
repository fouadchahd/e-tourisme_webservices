<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LinkedTourRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

/**
 * @ApiResource()
 * @ApiFilter(OrderFilter::class, properties={"poiOrder"})
 * @ORM\Entity(repositoryClass=LinkedTourRepository::class)
 */
class LinkedTour
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"tour:readItem"})
     */
    private $poiOrder;

    /**
     * @ORM\ManyToOne(targetEntity=Tour::class, inversedBy="linkedTours")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"poi:write"})
     */
    private $tour;

    /**
     * @ORM\ManyToOne(targetEntity=Poi::class, inversedBy="linkedTours")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"tour:readItem"})
     */
    private $poi;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoiOrder(): ?int
    {
        return $this->poiOrder;
    }

    public function setPoiOrder(int $poiOrder): self
    {
        $this->poiOrder = $poiOrder;

        return $this;
    }

    public function getTour(): ?Tour
    {
        return $this->tour;
    }

    public function setTour(?Tour $tour): self
    {
        $this->tour = $tour;

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
