<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Equipe
 *
 * @ORM\Table(name="equipe", indexes={@ORM\Index(name="fk_Responsable_eq", columns={"id_responsable"})})
 * @ORM\Entity
 *  @UniqueEntity(fields={"nomEquipe"}, message="Le nom est existe")
 */
class Equipe
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_equipe", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEquipe;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_equipe", type="string", length=50, nullable=false )
     * @Assert\Length (
     *     max=10,
     *     min=3,
     *     minMessage="nom obligatoirement supperieur à {{ limit }} caracteres " ,
     *     maxMessage="nom obligatoirement ne pase pas {{ limit }} caracteres")
     */
    private $nomEquipe;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_responsable", referencedColumnName="id")
     * })
     */
    private $idResponsable;

    public function getIdEquipe(): ?int
    {
        return $this->idEquipe;
    }

    public function getNomEquipe(): ?string
    {
        return $this->nomEquipe;
    }

    public function setNomEquipe(string $nomEquipe): self
    {
        $this->nomEquipe = $nomEquipe;

        return $this;
    }

    public function getIdResponsable(): ?User
    {
        return $this->idResponsable;
    }

    public function setIdResponsable(?User $idResponsable): self
    {
        $this->idResponsable = $idResponsable;

        return $this;
    }
    public function __toString()
    {
        return $this->nomEquipe;
        // TODO: Implement __toString() method.
    }


}
