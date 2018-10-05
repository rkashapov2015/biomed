<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * QueueEvent
 *
 * @ORM\Table(name="main.queue_event", indexes={@ORM\Index(name="ix_queue_event_peer", columns={"peer"}), @ORM\Index(name="ix_queue_event_event_time", columns={"event_time"}), @ORM\Index(name="ix_queue_event_uniqueid", columns={"unique_id"}), @ORM\Index(name="ix_queue_event_queue_name", columns={"queue_name"}), @ORM\Index(name="ix_queue_event_event_type", columns={"event_type"})})
 * @ORM\Entity
 */
class QueueEvent
{
    /**
     * @var int
     *
     * @ORM\Column(name="queue_event_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.queue_event_queue_event_id_seq", allocationSize=1, initialValue=1)
     */
    private $queueEventId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_time", type="datetime", nullable=false)
     */
    private $eventTime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="unique_id", type="text", nullable=true)
     */
    private $uniqueId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="queue_name", type="text", nullable=true)
     */
    private $queueName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="channel_name", type="text", nullable=true)
     */
    private $channelName;

    /**
     * @var string
     *
     * @ORM\Column(name="event_type", type="text", nullable=false)
     */
    private $eventType;

    /**
     * @var int|null
     *
     * @ORM\Column(name="p_position", type="integer", nullable=true)
     */
    private $pPosition;

    /**
     * @var int|null
     *
     * @ORM\Column(name="p_origposition", type="integer", nullable=true)
     */
    private $pOrigposition;

    /**
     * @var int|null
     *
     * @ORM\Column(name="p_waittime", type="integer", nullable=true)
     */
    private $pWaittime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="p_channel", type="text", nullable=true)
     */
    private $pChannel;

    /**
     * @var int|null
     *
     * @ORM\Column(name="p_logintime", type="integer", nullable=true)
     */
    private $pLogintime;

    /**
     * @var int|null
     *
     * @ORM\Column(name="p_holdtime", type="integer", nullable=true)
     */
    private $pHoldtime;

    /**
     * @var int|null
     *
     * @ORM\Column(name="p_calltime", type="integer", nullable=true)
     */
    private $pCalltime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="p_bridged_channel_unique_id", type="text", nullable=true)
     */
    private $pBridgedChannelUniqueId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="p_ringtime", type="integer", nullable=true)
     */
    private $pRingtime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="p_url", type="text", nullable=true)
     */
    private $pUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="p_caller_id", type="text", nullable=true)
     */
    private $pCallerId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="p_key", type="text", nullable=true)
     */
    private $pKey;

    /**
     * @var string|null
     *
     * @ORM\Column(name="p_extention", type="text", nullable=true)
     */
    private $pExtention;

    /**
     * @var string|null
     *
     * @ORM\Column(name="p_context", type="text", nullable=true)
     */
    private $pContext;

    /**
     * @var string|null
     *
     * @ORM\Column(name="peer", type="text", nullable=true)
     */
    private $peer;

    public function getQueueEventId(): ?int
    {
        return $this->queueEventId;
    }

    public function getEventTime(): ?\DateTimeInterface
    {
        return $this->eventTime;
    }

    public function setEventTime(\DateTimeInterface $eventTime): self
    {
        $this->eventTime = $eventTime;

        return $this;
    }

    public function getUniqueId(): ?string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(?string $uniqueId): self
    {
        $this->uniqueId = $uniqueId;

        return $this;
    }

    public function getQueueName(): ?string
    {
        return $this->queueName;
    }

    public function setQueueName(?string $queueName): self
    {
        $this->queueName = $queueName;

        return $this;
    }

    public function getChannelName(): ?string
    {
        return $this->channelName;
    }

    public function setChannelName(?string $channelName): self
    {
        $this->channelName = $channelName;

        return $this;
    }

    public function getEventType(): ?string
    {
        return $this->eventType;
    }

    public function setEventType(string $eventType): self
    {
        $this->eventType = $eventType;

        return $this;
    }

    public function getPPosition(): ?int
    {
        return $this->pPosition;
    }

    public function setPPosition(?int $pPosition): self
    {
        $this->pPosition = $pPosition;

        return $this;
    }

    public function getPOrigposition(): ?int
    {
        return $this->pOrigposition;
    }

    public function setPOrigposition(?int $pOrigposition): self
    {
        $this->pOrigposition = $pOrigposition;

        return $this;
    }

    public function getPWaittime(): ?int
    {
        return $this->pWaittime;
    }

    public function setPWaittime(?int $pWaittime): self
    {
        $this->pWaittime = $pWaittime;

        return $this;
    }

    public function getPChannel(): ?string
    {
        return $this->pChannel;
    }

    public function setPChannel(?string $pChannel): self
    {
        $this->pChannel = $pChannel;

        return $this;
    }

    public function getPLogintime(): ?int
    {
        return $this->pLogintime;
    }

    public function setPLogintime(?int $pLogintime): self
    {
        $this->pLogintime = $pLogintime;

        return $this;
    }

    public function getPHoldtime(): ?int
    {
        return $this->pHoldtime;
    }

    public function setPHoldtime(?int $pHoldtime): self
    {
        $this->pHoldtime = $pHoldtime;

        return $this;
    }

    public function getPCalltime(): ?int
    {
        return $this->pCalltime;
    }

    public function setPCalltime(?int $pCalltime): self
    {
        $this->pCalltime = $pCalltime;

        return $this;
    }

    public function getPBridgedChannelUniqueId(): ?string
    {
        return $this->pBridgedChannelUniqueId;
    }

    public function setPBridgedChannelUniqueId(?string $pBridgedChannelUniqueId): self
    {
        $this->pBridgedChannelUniqueId = $pBridgedChannelUniqueId;

        return $this;
    }

    public function getPRingtime(): ?int
    {
        return $this->pRingtime;
    }

    public function setPRingtime(?int $pRingtime): self
    {
        $this->pRingtime = $pRingtime;

        return $this;
    }

    public function getPUrl(): ?string
    {
        return $this->pUrl;
    }

    public function setPUrl(?string $pUrl): self
    {
        $this->pUrl = $pUrl;

        return $this;
    }

    public function getPCallerId(): ?string
    {
        return $this->pCallerId;
    }

    public function setPCallerId(?string $pCallerId): self
    {
        $this->pCallerId = $pCallerId;

        return $this;
    }

    public function getPKey(): ?string
    {
        return $this->pKey;
    }

    public function setPKey(?string $pKey): self
    {
        $this->pKey = $pKey;

        return $this;
    }

    public function getPExtention(): ?string
    {
        return $this->pExtention;
    }

    public function setPExtention(?string $pExtention): self
    {
        $this->pExtention = $pExtention;

        return $this;
    }

    public function getPContext(): ?string
    {
        return $this->pContext;
    }

    public function setPContext(?string $pContext): self
    {
        $this->pContext = $pContext;

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
