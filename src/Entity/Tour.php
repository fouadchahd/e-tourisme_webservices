<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *     normalizationContext={"skip_null_values"=false},
 *                           itemOperations={"put","delete",
 *                              "get"={
 *                                      "normalization_context"={
 *                                              "groups"={"tour:readItem"}
 *                                                               }
 *                                     }
 *                                          }
 * )
 * @ApiFilter (SearchFilter::class, properties={"city": "exact"})
 * @ORM\Entity(repositoryClass=TourRepository::class)
 */
class Tour
{
    #http://localhost:8000/api/tours.json?city=5
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"tour:readItem"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tour:readItem"})
     */
    private $name;

    /**
     * @Groups({"tour:readItem"})
     * @ORM\OneToMany(targetEntity=LinkedTour::class, mappedBy="tour", orphanRemoval=true)
     */
    private $linkedTours;

    /**
     * @Groups({"tour:readItem"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $cover;

    /**
     * @ORM\ManyToOne(targetEntity=City::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"tour:readItem"})
     */
    private $city;

    public function __construct()
    {
        $this->linkedTours = new ArrayCollection();
    }

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

    /**
     * @Groups({"tour:readItem"})
     */
    public function getNumberOfSights(): ?int
    {
        return $this->getLinkedTours()->count();
    }
    /**
     * @return Collection|LinkedTour[]
     */
    public function getLinkedTours(): Collection
    {

         $vlinkedtours = $this->linkedTours;


         return $vlinkedtours;

    }

    public function addLinkedTour(LinkedTour $linkedTour): self
    {
        if (!$this->linkedTours->contains($linkedTour)) {
            $this->linkedTours[] = $linkedTour;
            $linkedTour->setTour($this);
        }

        return $this;
    }

    public function removeLinkedTour(LinkedTour $linkedTour): self
    {
        if ($this->linkedTours->removeElement($linkedTour)) {
            // set the owning side to null (unless already changed)
            if ($linkedTour->getTour() === $this) {
                $linkedTour->setTour(null);
            }
        }

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): self
    {
        $this->cover = $cover;

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
