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
 * Shipping category mapped super-class spec.
 *
 * @author Pawęł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ShippingCategory extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\ShippingBundle\Entity\ShippingCategory');
    }

    function it_implements_Sylius_shipping_category_interface()
    {
        $this->shouldImplement('Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface');
    }

    function it_extends_Sylius_shipping_category_model()
    {
        $this->shouldHaveType('Sylius\Bundle\ShippingBundle\Model\ShippingCategory');
    }
}
