<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AsteriskRecordRepository")
 */
class AsteriskRecord
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $calldate;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $clid;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $src;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $dst;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $dcontext;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $channel;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $dstchannel;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $lastapp;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $lastdata;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="integer")
     */
    private $billsec;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $disposition;

    /**
     * @ORM\Column(type="integer")
     */
    private $amaflags;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $accountcode;

    /**
     * @ORM\Column(type="string", length=32, unique=true)
     */
    private $uniqueid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userfield;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $did;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $recordingfile;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $cnum;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $cnam;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $outbound_cnum;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $outbound_cnam;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $dst_cnam;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalldate(): ?\DateTimeInterface
    {
        return $this->calldate;
    }

    public function setCalldate(\DateTimeInterface $calldate): self
    {
        $this->calldate = $calldate;

        return $this;
    }

    public function getClid(): ?string
    {
        return $this->clid;
    }

    public function setClid(string $clid): self
    {
        $this->clid = $clid;

        return $this;
    }

    public function getSrc(): ?string
    {
        return $this->src;
    }

    public function setSrc(string $src): self
    {
        $this->src = $src;

        return $this;
    }

    public function getDst(): ?string
    {
        return $this->dst;
    }

    public function setDst(string $dst): self
    {
        $this->dst = $dst;

        return $this;
    }

    public function getDcontext(): ?string
    {
        return $this->dcontext;
    }

    public function setDcontext(string $dcontext): self
    {
        $this->dcontext = $dcontext;

        return $this;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function getDstchannel(): ?string
    {
        return $this->dstchannel;
    }

    public function setDstchannel(string $dstchannel): self
    {
        $this->dstchannel = $dstchannel;

        return $this;
    }

    public function getLastapp(): ?string
    {
        return $this->lastapp;
    }

    public function setLastapp(string $lastapp): self
    {
        $this->lastapp = $lastapp;

        return $this;
    }

    public function getLastdata(): ?string
    {
        return $this->lastdata;
    }

    public function setLastdata(string $lastdata): self
    {
        $this->lastdata = $lastdata;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getBillsec(): ?int
    {
        return $this->billsec;
    }

    public function setBillsec(int $billsec): self
    {
        $this->billsec = $billsec;

        return $this;
    }

    public function getDisposition(): ?string
    {
        return $this->disposition;
    }

    public function setDisposition(string $disposition): self
    {
        $this->disposition = $disposition;

        return $this;
    }

    public function getAmaflags(): ?int
    {
        return $this->amaflags;
    }

    public function setAmaflags(int $amaflags): self
    {
        $this->amaflags = $amaflags;

        return $this;
    }

    public function getAccountcode(): ?string
    {
        return $this->accountcode;
    }

    public function setAccountcode(string $accountcode): self
    {
        $this->accountcode = $accountcode;

        return $this;
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

    public function getUserfield(): ?string
    {
        return $this->userfield;
    }

    public function setUserfield(string $userfield): self
    {
        $this->userfield = $userfield;

        return $this;
    }

    public function getDid(): ?string
    {
        return $this->did;
    }

    public function setDid(string $did): self
    {
        $this->did = $did;

        return $this;
    }

    public function getRecordingfile(): ?string
    {
        return $this->recordingfile;
    }

    public function setRecordingfile(string $recordingfile): self
    {
        $this->recordingfile = $recordingfile;

        return $this;
    }

    public function getCnum(): ?string
    {
        return $this->cnum;
    }

    public function setCnum(string $cnum): self
    {
        $this->cnum = $cnum;

        return $this;
    }

    public function getCnam(): ?string
    {
        return $this->cnam;
    }

    public function setCnam(string $cnam): self
    {
        $this->cnam = $cnam;

        return $this;
    }

    public function getOutboundCnum(): ?string
    {
        return $this->outbound_cnum;
    }

    public function setOutboundCnum(string $outbound_cnum): self
    {
        $this->outbound_cnum = $outbound_cnum;

        return $this;
    }

    public function getOutboundCnam(): ?string
    {
        return $this->outbound_cnam;
    }

    public function setOutboundCnam(string $outbound_cnam): self
    {
        $this->outbound_cnam = $outbound_cnam;

        return $this;
    }

    public function getDstCnam(): ?string
    {
        return $this->dst_cnam;
    }

    public function setDstCnam(string $dst_cnam): self
    {
        $this->dst_cnam = $dst_cnam;
        return $this;
    }

    public function load($data) {
        if (!is_array($data)) {
            return false;
        }

        $columns = [
            'calldate', 'clid', 'src', 'dst', 'dcontext',
            'channel', 'dstchannel', 'lastapp', 'lastdata',
            'duration', 'billsec', 'disposition', 'amaflags',
            'accountcode', 'uniqueid', 'userfield', 'did',
            'recordingfile', 'cnum', 'cnam', 'outbound_cnum',
            'outbound_cnam', 'dst_cnam'
        ];

        foreach ($data as $key => $value) {
            if (in_array($key, $columns)) {
                if ($key == 'calldate') {
                    $this->$key = (new \DateTime($value));
                } else {
                    $this->$key = $value;
                }
            }
        }
        return true;
    }
}
