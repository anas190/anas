<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invitation
 *
 * @ORM\Table(name="invitation", indexes={@ORM\Index(name="fk_equipe", columns={"id_eq"}), @ORM\Index(name="fk_joueur", columns={"id_joueur"})})
 * @ORM\Entity
 */
class Invitation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_invitation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idInvitation;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=50, nullable=false)
     */
    private $etat;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_joueur", referencedColumnName="id")
     * })
     */
    private $idJoueur;

    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_eq", referencedColumnName="id_equipe")
     * })
     */
    private $idEq;

    public function getIdInvitation(): ?int
    {
        return $this->idInvitation;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIdJoueur(): ?User
    {
        return $this->idJoueur;
    }

    public function setIdJoueur(?User $idJoueur): self
    {
        $this->idJoueur = $idJoueur;

        return $this;
    }

    public function getIdEq(): ?Equipe
    {
        return $this->idEq;
    }

    public function setIdEq(?Equipe $idEq): self
    {
        $this->idEq = $idEq;

        return $this;
    }
    public function __toString()
    {
        return $this->etat;
        // TODO: Implement __toString() method.
    }

    


}
