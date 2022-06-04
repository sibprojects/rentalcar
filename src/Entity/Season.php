<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SeasonRepository::class)
 */
class Season
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
     * @ORM\Column(type="integer")
     */
    private $from_day;

    /**
     * @ORM\Column(type="integer")
     */
    private $from_month;

    /**
     * @ORM\Column(type="integer")
     */
    private $to_day;

    /**
     * @ORM\Column(type="integer")
     */
    private $to_month;

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

    public function getFromDay(): ?int
    {
        return $this->from_day;
    }

    public function setFromDay(int $from_day): self
    {
        $this->from_day = $from_day;

        return $this;
    }

    public function getFromMonth(): ?int
    {
        return $this->from_month;
    }

    public function setFromMonth(int $from_month): self
    {
        $this->from_month = $from_month;

        return $this;
    }

    public function getToDay(): ?int
    {
        return $this->to_day;
    }

    public function setToDay(int $to_day): self
    {
        $this->to_day = $to_day;

        return $this;
    }

    public function getToMonth(): ?int
    {
        return $this->to_month;
    }

    public function setToMonth(int $to_month): self
    {
        $this->to_month = $to_month;

        return $this;
    }
}
