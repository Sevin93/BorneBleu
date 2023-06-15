<?php

namespace App\Entity;

use App\Repository\PlanningRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Time;

use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Type;

#[ORM\Entity(repositoryClass: PlanningRepository::class)]
class Planning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column]
    private ?int $nb_heure;

    /**
     * @return int|null
     */
    public function getNbHeure(): ?int
    {
        return $this->nb_heure;
    }

    /**
     * @param int|null $nb_heure
     */
    public function setNbHeure(?int $nb_heure): void
    {
        $this->nb_heure = $nb_heure;
    }

    #[ORM\ManyToOne(inversedBy: 'plannings')]
    private ?Bornes $borne_id ;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date ;

    #[ORM\Column]
    private ?bool $etat = false;

    #[ORM\ManyToOne(inversedBy: 'plannings')]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $heure_debut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $heure_fin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorneId(): ?Bornes
    {
        return $this->borne_id;
    }

    public function setBorneId(?Bornes $borne_id): self
    {
        $this->borne_id = $borne_id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->pris;
    }

    public function setEtat(bool $pris): self
    {
        $this->pris = $pris;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(\DateTimeInterface $heure_debut): self
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heure_fin;
    }

    public function setHeureFin(\DateTimeInterface $heure_fin): self
    {
        $this->heure_fin = $heure_fin;

        return $this;
    }
}
