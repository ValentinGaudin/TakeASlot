<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
 * @Vich\Uploadable
 */
class Activity
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
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $description;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private ?string $image = null;

    /**
     * @Vich\UploadableField(mapping="poster_file", fileNameProperty="image")
     * @var File
     */
    private $posterFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $road;

    /**
     * @ORM\Column(type="integer")
     */
    private int $zip;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $town;

    /**
     * @ORM\OneToMany(targetEntity=Coach::class, mappedBy="activity")
     */
    private $coaches;

    /**
     * @ORM\ManyToOne(targetEntity=Calendar::class, inversedBy="activities")
     */
    private $activityRDV;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="activities")
     */
    private $owner;


    public function __construct()
    {
        $this->coaches = new ArrayCollection();
        $this->appointments = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of posterFile
     *
     * @return  File
     */
    public function getPosterFile(): ?File
    {
        return $this->posterFile;
    }

    /**
     * Set the value of posterFile
     *
     * @param  File  $posterFile
     */
    public function setPosterFile(File $image = null): Activity
    {
        $this->posterFile = $image;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getRoad(): ?string
    {
        return $this->road;
    }

    public function setRoad(string $road): self
    {
        $this->road = $road;

        return $this;
    }

    public function getZip(): ?int
    {
        return $this->zip;
    }

    public function setZip(int $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }

    /**
     * @return Collection|Coach[]
     */
    public function getCoaches(): Collection
    {
        return $this->coaches;
    }

    public function addCoach(Coach $coach): self
    {
        if (!$this->coaches->contains($coach)) {
            $this->coaches[] = $coach;
            $coach->setActivity($this);
        }

        return $this;
    }

    public function removeCoach(Coach $coach): self
    {
        if ($this->coaches->removeElement($coach)) {
            // set the owning side to null (unless already changed)
            if ($coach->getActivity() === $this) {
                $coach->setActivity(null);
            }
        }

        return $this;
    }

    public function getActivityRDV(): ?Calendar
    {
        return $this->activityRDV;
    }

    public function setActivityRDV(?Calendar $activityRDV): self
    {
        $this->activityRDV = $activityRDV;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|Appointment[]
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

}
