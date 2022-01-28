<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
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
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=TodoList::class, mappedBy="userTodo")
     */
    private $todoList;

    public function __construct()
    {
        $this->todoList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|TodoList[]
     */
    public function getTodoList(): Collection
    {
        return $this->todoList;
    }

    public function addTodoList(TodoList $todoList): self
    {
        if (!$this->todoList->contains($todoList)) {
            $this->todoList[] = $todoList;
            $todoList->setUserTodo($this);
        }

        return $this;
    }

    public function removeTodoList(TodoList $todoList): self
    {
        if ($this->todoList->removeElement($todoList)) {
            // set the owning side to null (unless already changed)
            if ($todoList->getUserTodo() === $this) {
                $todoList->setUserTodo(null);
            }
        }

        return $this;
    }
}
