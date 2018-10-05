<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * SystemData
 *
 * @ORM\Table(name="main.system_data", uniqueConstraints={@ORM\UniqueConstraint(name="ux_system_data_key", columns={"key"})})
 * @ORM\Entity
 */
class SystemData
{
    /**
     * @var int
     *
     * @ORM\Column(name="system_data_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.system_data_system_data_id_seq", allocationSize=1, initialValue=1)
     */
    private $systemDataId;

    /**
     * @var string
     *
     * @ORM\Column(name="key", type="text", nullable=false)
     */
    private $key;

    /**
     * @var string|null
     *
     * @ORM\Column(name="value", type="text", nullable=true)
     */
    private $value;

    public function getSystemDataId(): ?int
    {
        return $this->systemDataId;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }


}
