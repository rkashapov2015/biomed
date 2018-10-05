<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * Call
 *
 * @ORM\Table(name="main.call", uniqueConstraints={@ORM\UniqueConstraint(name="uix_call_linkedid", columns={"linkedid"})}, indexes={@ORM\Index(name="ix_call_ivr", columns={"ivr"}), @ORM\Index(name="ix_call_call_data", columns={"call_data"}), @ORM\Index(name="ix_call_operator_number", columns={"operator_number"}), @ORM\Index(name="ix_call_exten", columns={"exten"}), @ORM\Index(name="ix_call_src", columns={"src"}), @ORM\Index(name="ix_call_start_time", columns={"start_time"}), @ORM\Index(name="ix_call_direction", columns={"direction"}), @ORM\Index(name="ix_call_operator", columns={"operator"})})
 * @ORM\Entity(repositoryClass="App\Repository\CallRepository")
 */
class Call
{
    /**
     * @var int
     *
     * @ORM\Column(name="call_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.call_call_id_seq", allocationSize=1, initialValue=1)
     */
    private $callId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime", nullable=false)
     */
    private $createDate;

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
     * @var string
     *
     * @ORM\Column(name="linkedid", type="text", nullable=false)
     */
    private $linkedid;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="mix_monitor", type="boolean", nullable=true)
     */
    private $mixMonitor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="call_data", type="text", nullable=true)
     */
    private $callData;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="answer_time", type="datetime", nullable=true)
     */
    private $answerTime;

    /**
     * @var int|null
     *
     * @ORM\Column(name="direction", type="smallint", nullable=true)
     */
    private $direction;

    /**
     * @var string|null
     *
     * @ORM\Column(name="src", type="text", nullable=true)
     */
    private $src;

    /**
     * @var string|null
     *
     * @ORM\Column(name="exten", type="text", nullable=true)
     */
    private $exten;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ivr", type="text", nullable=true)
     */
    private $ivr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="queue", type="text", nullable=true)
     */
    private $queue;

    /**
     * @var int|null
     *
     * @ORM\Column(name="transfers_cnt", type="smallint", nullable=true)
     */
    private $transfersCnt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="call_duration", type="smallint", nullable=true)
     */
    private $callDuration;

    /**
     * @var int|null
     *
     * @ORM\Column(name="speak_duration", type="smallint", nullable=true)
     */
    private $speakDuration;

    /**
     * @var string|null
     *
     * @ORM\Column(name="trunk", type="text", nullable=true)
     */
    private $trunk;

    /**
     * @var string|null
     *
     * @ORM\Column(name="operator", type="text", nullable=true)
     */
    private $operator;

    /**
     * @var string|null
     *
     * @ORM\Column(name="operator_number", type="text", nullable=true)
     */
    private $operatorNumber;

    public function getCallId(): ?int
    {
        return $this->callId;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

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

    public function getLinkedid(): ?string
    {
        return $this->linkedid;
    }

    public function setLinkedid(string $linkedid): self
    {
        $this->linkedid = $linkedid;

        return $this;
    }

    public function getMixMonitor(): ?bool
    {
        return $this->mixMonitor;
    }

    public function setMixMonitor(?bool $mixMonitor): self
    {
        $this->mixMonitor = $mixMonitor;

        return $this;
    }

    public function getCallData(): ?string
    {
        return $this->callData;
    }

    public function setCallData(?string $callData): self
    {
        $this->callData = $callData;

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

    public function getDirection(): ?int
    {
        return $this->direction;
    }

    public function setDirection(?int $direction): self
    {
        $this->direction = $direction;

        return $this;
    }

    public function getSrc(): ?string
    {
        return $this->src;
    }

    public function setSrc(?string $src): self
    {
        $this->src = $src;

        return $this;
    }

    public function getExten(): ?string
    {
        return $this->exten;
    }

    public function setExten(?string $exten): self
    {
        $this->exten = $exten;

        return $this;
    }

    public function getIvr(): ?string
    {
        return $this->ivr;
    }

    public function setIvr(?string $ivr): self
    {
        $this->ivr = $ivr;

        return $this;
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

    public function getTransfersCnt(): ?int
    {
        return $this->transfersCnt;
    }

    public function setTransfersCnt(?int $transfersCnt): self
    {
        $this->transfersCnt = $transfersCnt;

        return $this;
    }

    public function getCallDuration(): ?int
    {
        return $this->callDuration;
    }

    public function setCallDuration(?int $callDuration): self
    {
        $this->callDuration = $callDuration;

        return $this;
    }

    public function getSpeakDuration(): ?int
    {
        return $this->speakDuration;
    }

    public function setSpeakDuration(?int $speakDuration): self
    {
        $this->speakDuration = $speakDuration;

        return $this;
    }

    public function getTrunk(): ?string
    {
        return $this->trunk;
    }

    public function setTrunk(?string $trunk): self
    {
        $this->trunk = $trunk;

        return $this;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    public function setOperator(?string $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    public function getOperatorNumber(): ?string
    {
        return $this->operatorNumber;
    }

    public function setOperatorNumber(?string $operatorNumber): self
    {
        $this->operatorNumber = $operatorNumber;

        return $this;
    }


}
