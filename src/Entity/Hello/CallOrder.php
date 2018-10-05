<?php

namespace App\Entity\Hello;

use Doctrine\ORM\Mapping as ORM;

/**
 * CallOrder
 *
 * @ORM\Table(name="main.call_order", indexes={@ORM\Index(name="idx_order_phone", columns={"phone"})})
 * @ORM\Entity
 */
class CallOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="order_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="main.call_order_order_id_seq", allocationSize=1, initialValue=1)
     */
    private $orderId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="text", nullable=true)
     */
    private $phone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ordertext", type="text", nullable=true)
     */
    private $ordertext;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false, options={"default"="now()"})
     */
    private $created = 'now()';

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getOrdertext(): ?string
    {
        return $this->ordertext;
    }

    public function setOrdertext(?string $ordertext): self
    {
        $this->ordertext = $ordertext;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }


}
