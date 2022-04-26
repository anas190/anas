<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AffectationFormateur
 *
 * @ORM\Table(name="affectation_formateur", indexes={@ORM\Index(name="fk_formateur", columns={"formateur_id"}), @ORM\Index(name="fk_formation1", columns={"formation_id"}), @ORM\Index(name="fk_reponse", columns={"reponse"})})
 * @ORM\Entity
 */
class AffectationFormateur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_affectation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAffectation;

    /**
     * @var \Formation
     *
     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="formation_id", referencedColumnName="id_formation")
     * })
     */
    private $formation;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="formateur_id", referencedColumnName="id")
     * })
     */
    private $formateur;

    /**
     * @var \Reponse
     *
     * @ORM\ManyToOne(targetEntity="Reponse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reponse", referencedColumnName="id_reponse")
     * })
     */
    private $reponse;


}
