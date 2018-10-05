<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * QueuePauseReason
 *
 * @ORM\Table(name="main.queue_pause_reason")
 * @ORM\Entity
 */
class QueuePauseReason
{
    /**
     * @var int
     *
     * @ORM\Column(name="queue_pause_reason_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.queue_pause_reason_queue_pause_reason_id_seq", allocationSize=1, initialValue=1)
     */
    private $queuePauseReasonId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", nullable=false)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_privileged", type="boolean", nullable=false)
     */
    private $isPrivileged = false;

    /**
     * @var string|null
     *
     * @ORM\Column(name="icon", type="blob", nullable=true)
     */
    private $icon;

    public function getQueuePauseReasonId(): ?int
    {
        return $this->queuePauseReasonId;
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

    public function getIsPrivileged(): ?bool
    {
        return $this->isPrivileged;
    }

    public function setIsPrivileged(bool $isPrivileged): self
    {
        $this->isPrivileged = $isPrivileged;

        return $this;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon): self
    {
        $this->icon = $icon;

        return $this;
    }


}
