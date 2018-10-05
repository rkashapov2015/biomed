<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * Peer
 *
 * @ORM\Table(name="main.peer", uniqueConstraints={@ORM\UniqueConstraint(name="ix_peer_interface", columns={"peer"})}, indexes={@ORM\Index(name="ix_peer_channel_type_id", columns={"channel_type_id"}), @ORM\Index(name="ix_peer_peer_type", columns={"peer_type"}), @ORM\Index(name="IDX_86E702A4E0D3C648", columns={"peer_group_id"})})
 * @ORM\Entity
 */
class Peer
{
    /**
     * @var int
     *
     * @ORM\Column(name="peer_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.peer_peer_id_seq", allocationSize=1, initialValue=1)
     */
    private $peerId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="text", nullable=true)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="paused", type="boolean", nullable=false)
     */
    private $paused;

    /**
     * @var int
     *
     * @ORM\Column(name="peer_type", type="integer", nullable=false, options={"comment"="0 - dfdf 1 -ddd "})*/
    private $peerType = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="peer", type="text", nullable=false)
     */
    private $peer;

    /**
     * @var bool
     *
     * @ORM\Column(name="show_in_panel", type="boolean", nullable=false, options={"default"="1"})
     */
    private $showInPanel = true;

    /**
     * @var string|null
     *
     * @ORM\Column(name="agent_name", type="text", nullable=true)
     */
    private $agentName;

    /**
     * @var int|null
     *
     * @ORM\Column(name="penalty", type="integer", nullable=true)
     */
    private $penalty;

    /**
     * @var \\PeerGroup
     *
     * @ORM\ManyToOne(targetEntity="PeerGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="peer_group_id", referencedColumnName="peer_group_id")
     * })
     */
    private $peerGroup;

    /**
     * @var \\ChannelType
     *
     * @ORM\ManyToOne(targetEntity="ChannelType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="channel_type_id", referencedColumnName="channel_type_id")
     * })
     */
    private $channelType;

    public function getPeerId(): ?int
    {
        return $this->peerId;
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

    public function getPaused(): ?bool
    {
        return $this->paused;
    }

    public function setPaused(bool $paused): self
    {
        $this->paused = $paused;

        return $this;
    }

    public function getPeerType(): ?int
    {
        return $this->peerType;
    }

    public function setPeerType(int $peerType): self
    {
        $this->peerType = $peerType;

        return $this;
    }

    public function getPeer(): ?string
    {
        return $this->peer;
    }

    public function setPeer(string $peer): self
    {
        $this->peer = $peer;

        return $this;
    }

    public function getShowInPanel(): ?bool
    {
        return $this->showInPanel;
    }

    public function setShowInPanel(bool $showInPanel): self
    {
        $this->showInPanel = $showInPanel;

        return $this;
    }

    public function getAgentName(): ?string
    {
        return $this->agentName;
    }

    public function setAgentName(?string $agentName): self
    {
        $this->agentName = $agentName;

        return $this;
    }

    public function getPenalty(): ?int
    {
        return $this->penalty;
    }

    public function setPenalty(?int $penalty): self
    {
        $this->penalty = $penalty;

        return $this;
    }

    public function getPeerGroup(): ?PeerGroup
    {
        return $this->peerGroup;
    }

    public function setPeerGroup(?PeerGroup $peerGroup): self
    {
        $this->peerGroup = $peerGroup;

        return $this;
    }

    public function getChannelType(): ?ChannelType
    {
        return $this->channelType;
    }

    public function setChannelType(?ChannelType $channelType): self
    {
        $this->channelType = $channelType;

        return $this;
    }


}
