<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * PeerInQueue
 *
 * @ORM\Table(name="main.peer_in_queue", uniqueConstraints={@ORM\UniqueConstraint(name="ux_peer_in_queue_endtime", columns={"peer", "queue"})}, indexes={@ORM\Index(name="ix_peer_in_queue_peer", columns={"peer"})})
 * @ORM\Entity
 */
class PeerInQueue
{
    /**
     * @var int
     *
     * @ORM\Column(name="peer_in_queue_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.peer_in_queue_peer_in_queue_id_seq", allocationSize=1, initialValue=1)
     */
    private $peerInQueueId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="queue", type="text", nullable=true)
     */
    private $queue;

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
     * @var string|null
     *
     * @ORM\Column(name="peer", type="text", nullable=true)
     */
    private $peer;

    public function getPeerInQueueId(): ?int
    {
        return $this->peerInQueueId;
    }

    public function getQueue(): ?string
    {
        return $this->queue;
    }

    public function setQueue(?string $queue): self
    {
        $this->queue = $queue;

        return $this;
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

    public function getPeer(): ?string
    {
        return $this->peer;
    }

    public function setPeer(?string $peer): self
    {
        $this->peer = $peer;

        return $this;
    }


}
