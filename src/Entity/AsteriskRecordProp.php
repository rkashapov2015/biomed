<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AsteriskRecordPropRepository")
 */
class AsteriskRecordProp
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $uniqueid;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $eventtype;

    /**
     * @ORM\Column(type="datetime")
     */
    private $eventtime;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $peer;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_asterisk;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEventtype(): ?string
    {
        return $this->eventtype;
    }

    public function setEventtype(string $eventtype): self
    {
        $this->eventtype = $eventtype;

        return $this;
    }

    public function getEventtime(): ?\DateTimeInterface
    {
        return $this->eventtime;
    }

    public function setEventtime(\DateTimeInterface $eventtime): self
    {
        $this->eventtime = $eventtime;

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

    public function getIdAsterisk(): ?int
    {
        return $this->id_asterisk;
    }

    public function setIdAsterisk(int $id_asterisk): self
    {
        $this->id_asterisk = $id_asterisk;

        return $this;
    }

    public function load($data) {
        if (!is_array($data)) {
            return false;
        }

        $columns = [
             'uniqueid', 'eventtype', 'eventtime', 'peer', 'id_asterisk'
        ];

        foreach ($data as $key => $value) {
            if (in_array($key, $columns)) {
                if ($key == 'eventtime') {
                    $this->$key = (new \DateTime($value));
                } else {
                    $this->$key = $value;
                }
            }
        }
        return true;
    }
}
