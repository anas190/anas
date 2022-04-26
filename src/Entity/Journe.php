<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Journe
 *
 * @ORM\Table(name="journe", indexes={@ORM\Index(name="fk_idcj", columns={"id_competition"})})
 * @ORM\Entity
 */
class Journe
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_journe", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idJourne;

    /**
     * @var int
     *
     * @ORM\Column(name="numJourne", type="integer", nullable=false)
     */
    private $numjourne;

    /**
     * @var string
     *
     * @ORM\Column(name="date_journe", type="string", length=255, nullable=false)
     */
    private $dateJourne;

    /**
     * @var \Competition
     *
     * @ORM\ManyToOne(targetEntity="Competition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_competition", referencedColumnName="id_competition")
     * })
     */
    private $idCompetition;


}
