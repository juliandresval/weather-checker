<?php

namespace App\Entity;

use App\Repository\CiudadRepository;
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
     * @ORM\Column(name="external_id", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $externalId = NULL;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zipcode", type="string", length=10, nullable=true, options={"default"="NULL"})
     */
    private $zipcode = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=3, nullable=false)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lon", type="decimal", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $lon = 'NULL';

    /**
     * @var float|null
     *
     * @ORM\Column(name="lat", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $lat = NULL;

    /**
     * @var string|null
     *
     * @ORM\Column(name="findname", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $findname = 'NULL';


}
