<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * Main.queue
 *
 * @ORM\Table(name="main.queue", uniqueConstraints={@ORM\UniqueConstraint(name="ux_queue_queue_name", columns={"queue_name"})})
 * @ORM\Entity
 */
class Queue
{
    /**
     * @var int
     *
     * @ORM\Column(name="queue_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.queue_queue_id_seq", allocationSize=1, initialValue=1)
     */
    private $queueId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="text", nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="queue_name", type="text", nullable=false)
     */
    private $queueName;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_visible", type="boolean", nullable=false)
     */
    private $isVisible;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_index", type="integer", nullable=false)
     */
    private $sortIndex;

    public function getQueueId(): ?int
    {
        return $this->queueId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getQueueName(): ?string
    {
        return $this->queueName;
    }

    public function setQueueName(string $queueName): self
    {
        $this->queueName = $queueName;

        return $this;
    }

    public function getIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function getSortIndex(): ?int
    {
        return $this->sortIndex;
    }

    public function setSortIndex(int $sortIndex): self
    {
        $this->sortIndex = $sortIndex;

        return $this;
    }


}
