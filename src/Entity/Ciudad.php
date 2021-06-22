<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ciudad
 *
 * @ORM\Table(name="ciudades")
 * @ORM\Entity
 */
class Ciudad
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
     * @var int|null
     *
     * @ORM\Column(name="owm_id", type="integer", nullable=true)
     */
    private $owmId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="zip_code", type="integer", nullable=true)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=127, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="findname", type="string", length=127, nullable=true)
     */
    private $findname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="state", type="string", length=3, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=3, nullable=false)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lat", type="decimal", precision=10, scale=7, nullable=true)
     */
    private $lat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lon", type="decimal", precision=10, scale=7, nullable=true)
     */
    private $lon;


}
