<?php

namespace App\Entity;

use App\Repository\HistoryRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\City;

/**
 * History
 *
 * @ORM\Table(name="history", indexes={@ORM\Index(name="history_cities_owm_id_fk", columns={"owm_id"})})
 * @ORM\Entity
 */
class History
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date", type="date", nullable=true, options={"default"="NULL"})
     */
    private $date = 'NULL';

    /**
     * @var float|null
     *
     * @ORM\Column(name="hum", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $hum = NULL;

    /**
     * @var float|null
     *
     * @ORM\Column(name="temp", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $temp = NULL;

    /**
     * @var Ciudad
     *
     * @ORM\ManyToOne(targetEntity="Ciudad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owm_id", referencedColumnName="external_id")
     * })
     */
    private $owm;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHum(): ?float
    {
        return $this->hum;
    }

    public function setHum(?float $hum): self
    {
        $this->hum = $hum;

        return $this;
    }

    public function getTemp(): ?float
    {
        return $this->temp;
    }

    public function setTemp(?float $temp): self
    {
        $this->temp = $temp;

        return $this;
    }

    public function getOwm(): ?City
    {
        return $this->owm;
    }

    public function setOwm(?City $owm): self
    {
        $this->owm = $owm;

        return $this;
    }


}
