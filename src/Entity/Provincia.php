<?php

namespace App\Entity;

use App\Repository\ProvinciaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProvinciaRepository::class)
 */
class Provincia
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity=Municipio::class, mappedBy="provincia", orphanRemoval=true)
     */
    private $municipios;

    public function __construct()
    {
        $this->municipios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection|Municipio[]
     */
    public function getMunicipios(): Collection
    {
        return $this->municipios;
    }

    public function addMunicipio(Municipio $municipio): self
    {
        if (!$this->municipios->contains($municipio)) {
            $this->municipios[] = $municipio;
            $municipio->setProvincia($this);
        }

        return $this;
    }

    public function removeMunicipio(Municipio $municipio): self
    {
        if ($this->municipios->removeElement($municipio)) {
            // set the owning side to null (unless already changed)
            if ($municipio->getProvincia() === $this) {
                $municipio->setProvincia(null);
            }
        }

        return $this;
    }
}
