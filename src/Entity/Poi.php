<?php

namespace App\Entity;

use App\Repository\PoiRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PoiRepository::class)
 */
class Poi
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
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;


    /**
     * @ORM\OneToMany(targetEntity=Description::class, mappedBy="poi", orphanRemoval=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Audio::class, mappedBy="poi", orphanRemoval=true)
     */
    private $audio;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="poi", orphanRemoval=true)
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity=Poi::class, inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Poi::class, mappedBy="parent",orphanRemoval=true)
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity=TypeOfAttraction::class, inversedBy="pois")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeOfAttraction;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="pois")
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    public function __construct()
    {
        $this->description = new ArrayCollection();
        $this->audio = new ArrayCollection();
        $this->photo = new ArrayCollection();
        $this->children = new ArrayCollection();
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

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    /**
     * @return Collection|Description[]
     */
    public function getDescription(): Collection
    {
        return $this->description;
    }

    public function addDescription(Description $description): self
    {
        if (!$this->description->contains($description)) {
            $this->description[] = $description;
            $description->setPoi($this);
        }

        return $this;
    }

    public function removeDescription(Description $description): self
    {
        if ($this->description->removeElement($description)) {
            // set the owning side to null (unless already changed)
            if ($description->getPoi() === $this) {
                $description->setPoi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Audio[]
     */
    public function getAudio(): Collection
    {
        return $this->audio;
    }

    public function addAudio(Audio $audio): self
    {
        if (!$this->audio->contains($audio)) {
            $this->audio[] = $audio;
            $audio->setPoi($this);
        }

        return $this;
    }

    public function removeAudio(Audio $audio): self
    {
        if ($this->audio->removeElement($audio)) {
            // set the owning side to null (unless already changed)
            if ($audio->getPoi() === $this) {
                $audio->setPoi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhoto(): Collection
    {
        return $this->photo;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photo->contains($photo)) {
            $this->photo[] = $photo;
            $photo->setPoi($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photo->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getPoi() === $this) {
                $photo->setPoi(null);
            }
        }

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function getTypeOfAttraction(): ?TypeOfAttraction
    {
        return $this->typeOfAttraction;
    }

    public function setTypeOfAttraction(?TypeOfAttraction $typeOfAttraction): self
    {
        $this->typeOfAttraction = $typeOfAttraction;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;
        return $this;
    }
}
