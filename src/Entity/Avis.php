<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvisRepository::class)
 */
class Avis
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
    private $nbrPoint;

    /**
     * @ORM\Column(type="text")
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="avis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $voyageur;

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class, inversedBy="avis")
     */
    private $annonce;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrPoint(): ?int
    {
        return $this->nbrPoint;
    }

    public function setNbrPoint(?int $nbrPoint): self
    {
        $this->nbrPoint = $nbrPoint;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getVoyageur(): ?Utilisateur
    {
        return $this->voyageur;
    }

    public function setVoyageur(?Utilisateur $voyageur): self
    {
        $this->voyageur = $voyageur;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }
}
