<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ShippingBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * This model represents single shipment.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Shipment implements ShipmentInterface
{
    /**
     * Shipment identifier.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Shipment state.
     *
     * @var string
     */
    protected $state;

    /**
     * Shipping method.
     *
     * @var ShippingMethodInterface
     */
    protected $method;

    /**
     * Shipment items.
     *
     * @var Collection
     */
    protected $items;

    /**
     * Tracking code for this shipment, if any required.
     *
     * @var string
     */
    protected $tracking;

    /**
     * Creation time.
     *
     * @var DateTime
     */
    protected $createdAt;

    /**
     * Last update time.
     *
     * @var DateTime
     */
    protected $updatedAt;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->state = ShipmentInterface::STATE_READY;
        $this->items = new ArrayCollection();
        $this->createdAt = new \DateTime('now');
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * {@inheritdoc}
     */
    public function setMethod(ShippingMethodInterface $method)
    {
        $this->method = $method;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * {@inheritdoc}
     */
    public function hasItem(ShipmentItemInterface $item)
    {
        return $this->items->contains($item);
    }

    /**
     * {@inheritdoc}
     */
    public function addItem(ShipmentItemInterface $item)
    {
        if (!$this->hasItem($item)) {
            $item->setShipment($this);
            $this->items->add($item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeItem(ShipmentItemInterface $item)
    {
        if ($this->hasItem($item)) {
            $item->setShipment(null);
            $this->items->removeElement($item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getShippables()
    {
        $shippables = new ArrayCollection();

        foreach ($this->items as $item) {
            $shippable = $item->getShippable();
            if (!$shippables->contains($shippable)) {
                $shippables->add($shippable);
            }
        }

        return $shippables;
    }

    /**
     * {@inheritdoc}
     */
    public function getTracking()
    {
        return $this->tracking;
    }

    /**
     * {@inheritdoc}
     */
    public function setTracking($tracking)
    {
        $this->tracking = $tracking;
    }

    /**
     * {@inheritdoc}
     */
    public function isTracked()
    {
        return null !== $this->tracking;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
