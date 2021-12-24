<?php

namespace App\Entity;

use App\Repository\ListToDoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Carbon\Carbon;

/**
 * @ORM\Entity(repositoryClass=ListToDoRepository::class)
 */
class ListToDo
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
     * @ORM\Column(type="date")
     */
    private $create_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $update_at;

    /**
     * @ORM\OneToMany(targetEntity=Item::class, mappedBy="listToDo")
     */
    private $items;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="list", cascade={"persist", "remove"})
     */
    private $owner;

    public function __construct() {
        $this->items = new ArrayCollection(); // TODO : Peut être à supprimer 
        $this->create_at = Carbon::now();
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

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeInterface $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeImmutable $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setListToDo($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getListToDo() === $this) {
                $item->setListToDo(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        // unset the owning side of the relation if necessary
        if ($owner === null && $this->owner !== null) {
            $this->owner->setList(null);
        }

        // set the owning side of the relation if necessary
        if ($owner !== null && $owner->getList() !== $this) {
            $owner->setList($this);
        }

        $this->owner = $owner;

        return $this;
    }

    public function canAddItem(){
        return count($this->items) < 10;
    }
}
