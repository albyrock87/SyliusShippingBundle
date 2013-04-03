<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\ShippingBundle\Entity;

use PHPSpec2\ObjectBehavior;

/**
 * Shipment item mapped superclass spec.
 *
 * @author Pawęł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ShipmentItem extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\ShippingBundle\Entity\ShipmentItem');
    }

    function it_implements_Sylius_shipment_item_interface()
    {
        $this->shouldImplement('Sylius\Bundle\ShippingBundle\Model\ShipmentItemInterface');
    }

    function it_extends_Sylius_shipment_item_model()
    {
        $this->shouldHaveType('Sylius\Bundle\ShippingBundle\Model\ShipmentItem');
    }
}
