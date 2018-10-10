<?php

namespace App\Entity\Common;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Common\QueueWaitingRepository")
 */
class QueueWaiting
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time_point;

    /**
     * @ORM\Column(type="float")
     */
    private $avg_queue;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_queue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimePoint(): ?\DateTimeInterface
    {
        return $this->time_point;
    }

    public function setTimePoint(\DateTimeInterface $time_point): self
    {
        $this->time_point = $time_point;

        return $this;
    }

    public function getAvgQueue(): ?float
    {
        return $this->avg_queue;
    }

    public function setAvgQueue(float $avg_queue): self
    {
        $this->avg_queue = $avg_queue;

        return $this;
    }

    public function getMaxQueue(): ?int
    {
        return $this->max_queue;
    }

    public function setMaxQueue(int $max_queue): self
    {
        $this->max_queue = $max_queue;

        return $this;
    }
}
