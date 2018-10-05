<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * QueuePause
 *
 * @ORM\Table(name="main.queue_pause", uniqueConstraints={@ORM\UniqueConstraint(name="ix_queue_pause_user_end_time", columns={"peer"})}, indexes={@ORM\Index(name="ix_queue_pause_peer", columns={"peer"})})
 * @ORM\Entity
 */
class QueuePause
{
    /**
     * @var int
     *
     * @ORM\Column(name="queue_pause_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.queue_pause_queue_pause_id_seq", allocationSize=1, initialValue=1)
     */
    private $queuePauseId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="datetime", nullable=false)
     */
    private $startTime;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="end_time", type="datetime", nullable=true)
     */
    private $endTime;

    /**
     * @var int|null
     *
     * @ORM\Column(name="queue_pause_reason_id", type="integer", nullable=true)
     */
    private $queuePauseReasonId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var string|null
     *
     * @ORM\Column(name="peer", type="text", nullable=true)
     */
    private $peer;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_privileged", type="boolean", nullable=false)
     */
    private $isPrivileged = false;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false, options={"default"="1"})
     */
    private $type = '1';

    /**
     * @var int|null
     *
     * @ORM\Column(name="late", type="integer", nullable=true)
     */
    private $late;

    /**
     * @var int|null
     *
     * @ORM\Column(name="early", type="integer", nullable=true)
     */
    private $early;

    /**
     * @var int|null
     *
     * @ORM\Column(name="user_pause_id", type="integer", nullable=true)
     */
    private $userPauseId;

    public function getQueuePauseId(): ?int
    {
        return $this->queuePauseId;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(?\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getQueuePauseReasonId(): ?int
    {
        return $this->queuePauseReasonId;
    }

    public function setQueuePauseReasonId(?int $queuePauseReasonId): self
    {
        $this->queuePauseReasonId = $queuePauseReasonId;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getPeer(): ?string
    {
        return $this->peer;
    }

    public function setPeer(?string $peer): self
    {
        $this->peer = $peer;

        return $this;
    }

    public function getIsPrivileged(): ?bool
    {
        return $this->isPrivileged;
    }

    public function setIsPrivileged(bool $isPrivileged): self
    {
        $this->isPrivileged = $isPrivileged;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLate(): ?int
    {
        return $this->late;
    }

    public function setLate(?int $late): self
    {
        $this->late = $late;

        return $this;
    }

    public function getEarly(): ?int
    {
        return $this->early;
    }

    public function setEarly(?int $early): self
    {
        $this->early = $early;

        return $this;
    }

    public function getUserPauseId(): ?int
    {
        return $this->userPauseId;
    }

    public function setUserPauseId(?int $userPauseId): self
    {
        $this->userPauseId = $userPauseId;

        return $this;
    }


}
