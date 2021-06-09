<?php

namespace App\Entity;

use App\Repository\LinkedTourRepository;
use Doctrine\ORM\Mapping as ORM;

/**
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
     */
    private $poiOrder;

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
}
