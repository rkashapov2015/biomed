<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChannelType
 *
 * @ORM\Table(name="main.channel_type", uniqueConstraints={@ORM\UniqueConstraint(name="uix_channel_type_name", columns={"name"})})
 * @ORM\Entity
 */
class ChannelType
{
    /**
     * @var int
     *
     * @ORM\Column(name="channel_type_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.channel_type_channel_type_id_seq", allocationSize=1, initialValue=1)
     */
    private $channelTypeId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", nullable=false)
     */
    private $name;

    public function getChannelTypeId(): ?int
    {
        return $this->channelTypeId;
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


}
