<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * CallDetail
 *
 * @ORM\Table(name="main.call_detail", indexes={@ORM\Index(name="call_detail_call_id", columns={"call_id"})})
 * @ORM\Entity
 */
class CallDetail
{
    /**
     * @var int
     *
     * @ORM\Column(name="call_detail_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.call_detail_call_detail_id_seq", allocationSize=1, initialValue=1)
     */
    private $callDetailId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="event", type="text", nullable=true)
     */
    private $event;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime", nullable=false)
     */
    private $time;

    /**
     * @var \\Call
     *
     * @ORM\ManyToOne(targetEntity="Call")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="call_id", referencedColumnName="call_id")
     * })
     */
    private $call;

    public function getCallDetailId(): ?int
    {
        return $this->callDetailId;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }

    public function setEvent(?string $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

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
