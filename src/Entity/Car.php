<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
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
    private $Brand;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Model;

    /**
     * @ORM\Column(type="integer")
     */
    private $Stock;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price_season_high;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price_season_mid;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price_season_low;

    private $price;
    private $average_price;

    /**
     * @ORM\OneToMany(targetEntity=Rental::class, mappedBy="car")
     */
    private $rentals;

    public function __construct()
    {
        $this->rentals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->Brand;
    }

    public function setBrand(string $Brand): self
    {
        $this->Brand = $Brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->Model;
    }

    public function setModel(string $Model): self
    {
        $this->Model = $Model;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->Stock;
    }

    public function setStock(int $Stock): self
    {
        $this->Stock = $Stock;

        return $this;
    }

    public function getPriceSeasonHigh(): ?string
    {
        return $this->price_season_high;
    }

    public function setPriceSeasonHigh(string $price_season_high): self
    {
        $this->price_season_high = $price_season_high;

        return $this;
    }

    public function getPriceSeasonMid(): ?string
    {
        return $this->price_season_mid;
    }

    public function setPriceSeasonMid(string $price_season_mid): self
    {
        $this->price_season_mid = $price_season_mid;

        return $this;
    }

    public function getPriceSeasonLow(): ?string
    {
        return $this->price_season_low;
    }

    public function setPriceSeasonLow(string $price_season_low): self
    {
        $this->price_season_low = $price_season_low;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSeasonPrice(string $type): ?float
    {
        $price_name = "price_season_".$type;

        return $this->$price_name;
    }

    public function getAveragePrice(): ?float
    {
        return $this->average_price;
    }

    public function setAveragePrice(string $average_price): self
    {
        $this->average_price = $average_price;

        return $this;
    }

    /**
     * @return Collection<int, Rental>
     */
    public function getRentals(): Collection
    {
        return $this->rentals;
    }

    public function addRental(Rental $rental): self
    {
        if (!$this->rentals->contains($rental)) {
            $this->rentals[] = $rental;
            $rental->setCar($this);
        }

        return $this;
    }

    public function removeRental(Rental $rental): self
    {
        if ($this->rentals->removeElement($rental)) {
            // set the owning side to null (unless already changed)
            if ($rental->getCar() === $this) {
                $rental->setCar(null);
            }
        }

        return $this;
    }

}
