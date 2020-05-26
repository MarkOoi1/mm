<?php

namespace App\Entity;

use App\Repository\RegionsRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass=RegionsRepository::class)
 */
class Regions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Markets::class, mappedBy="markets")
     */
    private $markets;

    public function __construct()
    {
        $this->markets = new ArrayCollection();
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
     * @return Collection|Markets[]
     */
    public function getMarkets(): Collection
    {
        return $this->markets;
    }

    public function addMarket(Markets $market): self
    {
        if (!$this->markets->contains($market)) {
            $this->markets[] = $market;
            $market->addMarket($this);
        }

        return $this;
    }

    public function removeMarket(Markets $market): self
    {
        if ($this->markets->contains($market)) {
            $this->markets->removeElement($market);
            $market->removeMarket($this);
        }

        return $this;
    }
}
