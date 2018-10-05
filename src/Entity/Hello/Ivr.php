<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ivr
 *
 * @ORM\Table(name="main.ivr")
 * @ORM\Entity
 */
class Ivr
{
    /**
     * @var int
     *
     * @ORM\Column(name="ivr_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.ivr_ivr_id_seq", allocationSize=1, initialValue=1)
     */
    private $ivrId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    public function getIvrId(): ?int
    {
        return $this->ivrId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


}
