<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 * @UniqueEntity(
 *     fields={"name", "listToDo"},
 *     errorPath="name",
 *     message="Tu as déjà une tache de ce nom dans ta liste."
 * )
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="date")
     */
    private $creation_date;

    /**
     * @ORM\ManyToOne(targetEntity=ListToDo::class, inversedBy="items")
     */
    private $listToDo;

    public function __construct() {
        $this->creation_date = Carbon::now();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getListToDo(): ?ListToDo
    {
        return $this->listToDo;
    }

    public function setListToDo(?ListToDo $listToDo): self
    {
        $this->listToDo = $listToDo;

        return $this;
    }

    public function isValid(): bool {

        if (
            !empty($this->name) && is_string($this->name)
            && strlen($this->content) <=1000
            && $this->creation_date
        ) {
            return true;
        }

        return false;
    }

    public function __toString()
    {
        return $this->name;
    }
}
