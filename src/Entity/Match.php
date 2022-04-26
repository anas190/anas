<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Match
 *
 * @ORM\Table(name="match", indexes={@ORM\Index(name="fk_eq1", columns={"Equipe1"}), @ORM\Index(name="fk_eq2", columns={"Equipe2"}), @ORM\Index(name="fk_journee", columns={"id_journe"})})
 * @ORM\Entity
 */
class Match
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_match", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMatch;

    /**
     * @var string
     *
     * @ORM\Column(name="Equipe1", type="string", length=255, nullable=false)
     */
    private $equipe1;

    /**
     * @var string
     *
     * @ORM\Column(name="Equipe2", type="string", length=255, nullable=false)
     */
    private $equipe2;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=50, nullable=false)
     */
    private $etat;

    /**
     * @var \Journe
     *
     * @ORM\ManyToOne(targetEntity="Journe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_journe", referencedColumnName="id_journe")
     * })
     */
    private $idJourne;


}
