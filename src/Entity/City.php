<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="cities")
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $owm_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $zip_code;

    /**
     * @ORM\Column(type="string", length=127)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $findname;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $country;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, nullable=true)
     */
    private $lon;

    /**
     * @ORM\OneToMany(targetEntity=History::class, mappedBy="city")
     */
    private $histories;

    public function __construct()
    {
        $this->histories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwmId(): ?int
    {
        return $this->owm_id;
    }

    public function setOwmId(?int $owm_id): self
    {
        $this->owm_id = $owm_id;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zip_code;
    }

    public function setZipCode(?int $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
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

    public function getFindname(): ?string
    {
        return $this->findname;
    }

    public function setFindname(?string $findname): self
    {
        $this->findname = $findname;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLon(): ?string
    {
        return $this->lon;
    }

    public function setLon(?string $lon): self
    {
        $this->lon = $lon;

        return $this;
    }

    /**
     * @return Collection|History[]
     */
    public function getHistories(): Collection
    {
        return $this->histories;
    }

    public function addHistory(History $history): self
    {
        if (!$this->histories->contains($history)) {
            $this->histories[] = $history;
            $history->setCity($this);
        }

        return $this;
    }

    public function removeHistory(History $history): self
    {
        if ($this->histories->removeElement($history)) {
            // set the owning side to null (unless already changed)
            if ($history->getCity() === $this) {
                $history->setCity(null);
            }
        }

        return $this;
    }
}
