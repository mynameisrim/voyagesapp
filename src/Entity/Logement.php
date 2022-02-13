<?php

namespace App\Entity;

use App\Repository\LogementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LogementRepository::class)
 */
class Logement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank(
     *     message="titre de logement est obligatoire"
     * )
     * 
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank(
     *     message="description de logement est obligatoire"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank(
     *     message="addresse de logement est obligatoire"
     * )
     * 
     */
    private $addresse;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="logements")
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $hote;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="logement")
     */
    private $annonces;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAddresse(): ?string
    {
        return $this->addresse;
    }

    public function setAddresse(string $addresse): self
    {
        $this->addresse = $addresse;

        return $this;
    }

    public function getHote(): ?Utilisateur
    {
        return $this->hote;
    }

    public function setHote(?Utilisateur $hote): self
    {
        $this->hote = $hote;

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setLogement($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getLogement() === $this) {
                $annonce->setLogement(null);
            }
        }

        return $this;
    }

}
