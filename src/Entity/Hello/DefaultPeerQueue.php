<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * DefaultPeerQueue
 *
 * @ORM\Table(name="main.default_peer_queue", indexes={@ORM\Index(name="IDX_6D103ADA20D91DB4", columns={"peer_id"}), @ORM\Index(name="IDX_6D103ADA477B5BAE", columns={"queue_id"})})
 * @ORM\Entity
 */
class DefaultPeerQueue
{
    /**
     * @var int
     *
     * @ORM\Column(name="peer_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $peerId;

    /**
     * @var \\Queue
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Queue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="queue_id", referencedColumnName="queue_id")
     * })
     */
    private $queue;

    public function getPeerId(): ?int
    {
        return $this->peerId;
    }

    public function getQueue(): ?Queue
    {
        return $this->queue;
    }

    public function setQueue(?Queue $queue): self
    {
        $this->queue = $queue;

        return $this;
    }


}
