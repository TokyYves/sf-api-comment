<?php 

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

trait AddTimestamp
{
     /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"read_post", "write_post","read_user"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"read_post", "write_post","read_user"})
     */
    private $updatedAt;
    
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}