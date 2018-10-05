<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * Did
 *
 * @ORM\Table(name="main.did")
 * @ORM\Entity
 */
class Did
{
    /**
     * @var int
     *
     * @ORM\Column(name="did_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.did_did_id_seq", allocationSize=1, initialValue=1)
     */
    private $didId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="text", nullable=false)
     */
    private $number;

    public function getDidId(): ?int
    {
        return $this->didId;
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

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }


}
