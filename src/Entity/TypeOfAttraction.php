<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\TypeOfAttractionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\{SearchFilter,ExistsFilter};

/**
 * @ORM\Entity(repositoryClass=TypeOfAttractionRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"toa:read"}},
 *     subresourceOperations={
 *          "type_of_attractions_children_types_get_subresource"={
 *              "method"="GET",
 *              "normalization_context"={"groups"={"read_subresource"}}
 *          },
 *           "children_types_get_subresource"={
 *               "path"="/type_of_attractions/{id}/children.{_format}",
 *          }
 *      }
 *     )
 * @ApiFilter(ExistsFilter::class, properties={"parentType"})
 * @ApiFilter(SearchFilter::class, properties={"parentType": "exact"})
 * @UniqueEntity("type",message="this type name is already used")
 */
class TypeOfAttraction
{
    #api/type_of_attractions.json?exists[parentType]=true/false
    #api/type_of_attractions/{id}/children.json
    #api/type_of_attractions.json?parentType=11
    #api/type_of_attractions.json?parentType%5B%5D=11&parentType%5B%5D=12
    #api/type_of_attractions.json?parentType[]=11&parentType[]=12
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     * @Groups({"read_subresource","toa:read","poi:write"})
     */
    private $id;

    /**
     * @Groups({"read_subresource","toa:read","poi_item:read"})
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=TypeOfAttraction::class, inversedBy="childrenTypes")
     * @Groups({"poi_item:read"})
     */
    private $parentType;

    /**
     * @ORM\OneToMany(targetEntity=TypeOfAttraction::class, mappedBy="parentType",orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     * @Groups({"toa:read"})
     */
    private $childrenTypes;

    /**
     * @Ignore
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


