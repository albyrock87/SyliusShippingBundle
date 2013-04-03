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
 * Default shipping category entity spec.
 *
 * @author Pawęł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class DefaultShippingCategory extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\ShippingBundle\Entity\DefaultShippingCategory');
    }

    function it_implements_Sylius_shipping_category_interface()
    {
        $this->shouldImplement('Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface');
    }

    function it_extends_Sylius_shipping_category_mapped_superclass()
    {
        $this->shouldHaveType('Sylius\Bundle\ShippingBundle\Entity\ShippingCategory');
    }
}
