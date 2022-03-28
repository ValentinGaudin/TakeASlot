<?php

namespace App\Entity;

use App\Repository\SlotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=SlotRepository::class)
 */
class Slot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private string $background_color;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private string $border_color;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private string $text_color;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="userRDV")
     */
    private Collection $users;

    /**
     * @ORM\ManyToOne(targetEntity=Activity::class, inversedBy="slots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="appointments")
     */
    private $userAppointment;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->appointments = new ArrayCollection();
        $this->userAppointment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

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

    public function getBackgroundColor(): ?string
    {
        return $this->background_color;
    }

    public function setBackgroundColor(string $background_color): self
    {
        $this->background_color = $background_color;

        return $this;
    }

    public function getBorderColor(): ?string
    {
        return $this->border_color;
    }

    public function setBorderColor(string $border_color): self
    {
        $this->border_color = $border_color;

        return $this;
    }

    public function getTextColor(): ?string
    {
        return $this->text_color;
    }

    public function setTextColor(string $text_color): self
    {
        $this->text_color = $text_color;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserAppointment(): Collection
    {
        return $this->userAppointment;
    }

    public function addUserAppointment(User $userAppointment): self
    {
        if (!$this->userAppointment->contains($userAppointment)) {
            $this->userAppointment[] = $userAppointment;
            $userAppointment->addAppointment($this);
        }

        return $this;
    }

    public function removeUserAppointment(User $userAppointment): self
    {
        if ($this->userAppointment->removeElement($userAppointment)) {
            $userAppointment->removeAppointment($this);
        }

        return $this;
    }

}
