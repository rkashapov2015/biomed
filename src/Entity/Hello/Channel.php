<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * Channel
 *
 * @ORM\Table(name="main.channel", indexes={@ORM\Index(name="ix_channel_bridge_to", columns={"bridge_to"}), @ORM\Index(name="ix_channel_call_id", columns={"call_id"}), @ORM\Index(name="ix_answer_time", columns={"answer_time"}), @ORM\Index(name="ix_channel_end_time", columns={"end_time"}), @ORM\Index(name="ix_channel_destination_num", columns={"destination_num"}), @ORM\Index(name="ix_channel_uniqueid", columns={"uniqueid"}), @ORM\Index(name="ix_channel_channame", columns={"channame"}), @ORM\Index(name="ix_channel_source_num", columns={"source_num"}), @ORM\Index(name="ix_channel_start_time", columns={"start_time"})})
 * @ORM\Entity
 */
class Channel
{
    /**
     * @var int
     *
     * @ORM\Column(name="channel_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.channel_channel_id_seq", allocationSize=1, initialValue=1)
     */
    private $channelId;

    /**
     * @var string
     *
     * @ORM\Column(name="uniqueid", type="text", nullable=false)
     */
    private $uniqueid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="source_num", type="text", nullable=true)
     */
    private $sourceNum;

    /**
     * @var string|null
     *
     * @ORM\Column(name="destination_num", type="text", nullable=true)
     */
    private $destinationNum;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="datetime", nullable=false)
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetime", nullable=false)
     */
    private $endTime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="peer", type="text", nullable=true)
     */
    private $peer;

    /**
     * @var string|null
     *
     * @ORM\Column(name="state", type="text", nullable=true)
     */
    private $state;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="answer_time", type="datetime", nullable=true)
     */
    private $answerTime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="channame", type="text", nullable=true)
     */
    private $channame;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bridge_to", type="text", nullable=true)
     */
    private $bridgeTo;

    /**
     * @var \\Call
     *
     * @ORM\ManyToOne(targetEntity="Call")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="call_id", referencedColumnName="call_id")
     * })
     */
    private $call;

    public function getChannelId(): ?int
    {
        return $this->channelId;
    }

    public function getUniqueid(): ?string
    {
        return $this->uniqueid;
    }

    public function setUniqueid(string $uniqueid): self
    {
        $this->uniqueid = $uniqueid;

        return $this;
    }

    public function getSourceNum(): ?string
    {
        return $this->sourceNum;
    }

    public function setSourceNum(?string $sourceNum): self
    {
        $this->sourceNum = $sourceNum;

        return $this;
    }

    public function getDestinationNum(): ?string
    {
        return $this->destinationNum;
    }

    public function setDestinationNum(?string $destinationNum): self
    {
        $this->destinationNum = $destinationNum;

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

    public function setEndTime(\DateTimeInterface $endTime): self
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

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getAnswerTime(): ?\DateTimeInterface
    {
        return $this->answerTime;
    }

    public function setAnswerTime(?\DateTimeInterface $answerTime): self
    {
        $this->answerTime = $answerTime;

        return $this;
    }

    public function getChanname(): ?string
    {
        return $this->channame;
    }

    public function setChanname(?string $channame): self
    {
        $this->channame = $channame;

        return $this;
    }

    public function getBridgeTo(): ?string
    {
        return $this->bridgeTo;
    }

    public function setBridgeTo(?string $bridgeTo): self
    {
        $this->bridgeTo = $bridgeTo;

        return $this;
    }

    public function getCall(): ?Call
    {
        return $this->call;
    }

    public function setCall(?Call $call): self
    {
        $this->call = $call;

        return $this;
    }


}
