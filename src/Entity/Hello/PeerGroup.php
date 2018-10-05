<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * PeerGroup
 *
 * @ORM\Table(name="main.peer_group")
 * @ORM\Entity
 */
class PeerGroup
{
    /**
     * @var int
     *
     * @ORM\Column(name="peer_group_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.peer_group_peer_group_id_seq", allocationSize=1, initialValue=1)
     */
    private $peerGroupId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_index", type="integer", nullable=false)
     */
    private $sortIndex;

    public function getPeerGroupId(): ?int
    {
        return $this->peerGroupId;
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

    public function getSortIndex(): ?int
    {
        return $this->sortIndex;
    }

    public function setSortIndex(int $sortIndex): self
    {
        $this->sortIndex = $sortIndex;

        return $this;
    }


}
