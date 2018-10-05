<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * CallApp
 *
 * @ORM\Table(name="main.call_app", indexes={@ORM\Index(name="ix_call_app_app_name", columns={"channel_appname"}), @ORM\Index(name="ix_call_app_app_start", columns={"app_start"}), @ORM\Index(name="ix_call_app_call_id", columns={"call_id"})})
 * @ORM\Entity
 */
class CallApp
{
    /**
     * @var int
     *
     * @ORM\Column(name="call_app_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.call_app_call_app_id_seq", allocationSize=1, initialValue=1)
     */
    private $callAppId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="app_start", type="datetime", nullable=false)
     */
    private $appStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="app_end", type="datetime", nullable=false)
     */
    private $appEnd;

    /**
     * @var string|null
     *
     * @ORM\Column(name="channel_appname", type="text", nullable=true)
     */
    private $channelAppname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="channel_appdata", type="text", nullable=true)
     */
    private $channelAppdata;

    /**
     * @var string|null
     *
     * @ORM\Column(name="exten", type="text", nullable=true)
     */
    private $exten;

    /**
     * @var \\Call
     *
     * @ORM\ManyToOne(targetEntity="Call")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="call_id", referencedColumnName="call_id")
     * })
     */
    private $call;

    public function getCallAppId(): ?int
    {
        return $this->callAppId;
    }

    public function getAppStart(): ?\DateTimeInterface
    {
        return $this->appStart;
    }

    public function setAppStart(\DateTimeInterface $appStart): self
    {
        $this->appStart = $appStart;

        return $this;
    }

    public function getAppEnd(): ?\DateTimeInterface
    {
        return $this->appEnd;
    }

    public function setAppEnd(\DateTimeInterface $appEnd): self
    {
        $this->appEnd = $appEnd;

        return $this;
    }

    public function getChannelAppname(): ?string
    {
        return $this->channelAppname;
    }

    public function setChannelAppname(?string $channelAppname): self
    {
        $this->channelAppname = $channelAppname;

        return $this;
    }

    public function getChannelAppdata(): ?string
    {
        return $this->channelAppdata;
    }

    public function setChannelAppdata(?string $channelAppdata): self
    {
        $this->channelAppdata = $channelAppdata;

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
