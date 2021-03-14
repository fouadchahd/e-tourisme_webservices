<?php

namespace App\Entity;

use App\Repository\TypeOfAttractionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeOfAttractionRepository::class)
 */
class TypeOfAttraction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=TypeOfAttraction::class, inversedBy="childrenTypes")
     */
    private $parentType;

    /**
     * @ORM\OneToMany(targetEntity=TypeOfAttraction::class, mappedBy="parentType")
     */
    private $childrenTypes;

    /**
     * @ORM\OneToMany(targetEntity=Poi::class, mappedBy="typeOfAttraction", orphanRemoval=true)
     */
    private $pois;

    public function __construct()
    {
        $this->childrenTypes = new ArrayCollection();
        $this->pois = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getParentType(): ?self
    {
        return $this->parentType;
    }

    public function setParentType(?self $parentType): self
    {
        $this->parentType = $parentType;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildrenTypes(): Collection
    {
        return $this->childrenTypes;
    }

    public function addChildrenType(self $childrenType): self
    {
        if (!$this->childrenTypes->contains($childrenType)) {
            $this->childrenTypes[] = $childrenType;
            $childrenType->setParentType($this);
        }

        return $this;
    }

    public function removeChildrenType(self $childrenType): self
    {
        if ($this->childrenTypes->removeElement($childrenType)) {
            // set the owning side to null (unless already changed)
            if ($childrenType->getParentType() === $this) {
                $childrenType->setParentType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Poi[]
     */
    public function getPois(): Collection
    {
        return $this->pois;
    }

    public function addPoi(Poi $poi): self
    {
        if (!$this->pois->contains($poi)) {
            $this->pois[] = $poi;
            $poi->setTypeOfAttraction($this);
        }

        return $this;
    }

    public function removePoi(Poi $poi): self
    {
        if ($this->pois->removeElement($poi)) {
            // set the owning side to null (unless already changed)
            if ($poi->getTypeOfAttraction() === $this) {
                $poi->setTypeOfAttraction(null);
            }
        }

        return $this;
    }
}


