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
     * @var \City
     *
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owm_id", referencedColumnName="owm_id")
     * })
     */
    private $owm;


}
