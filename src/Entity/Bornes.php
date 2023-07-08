<?php

namespace App\Entity;

use App\Repository\BornesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BornesRepository::class)]
class Bornes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column]
    private ?int $numero_borne;


    #[ORM\Column]
    private ?int $nb_heure;

    #[ORM\OneToMany(mappedBy: 'borne_id', targetEntity: Planning::class)]
    private Collection $plannings;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroBorne(): ?int
    {
        return $this->numero_borne;
    }

    public function setNumeroBorne(int $numero_borne): self
    {
        $this->numero_borne = $numero_borne;

        return $this;
    }

    
   
    public function __toString(): string
    {
        return $this->getNumeroBorne();
    }
}
