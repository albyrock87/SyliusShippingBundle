<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\ShippingBundle\Model;

use PHPSpec2\ObjectBehavior;

/**
 * Shipping category model spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ShippingCategory extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\ShippingBundle\Model\ShippingCategory');
    }

    function it_implements_Sylius_shipping_category_interface()
    {
        $this->shouldImplement('Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface');
    }

    function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_is_unnamed_by_default()
    {
        $this->getName()->shouldReturn(null);
    }

    function its_name_is_mutable()
    {
        $this->setName('Shippingable goods');
        $this->getName()->shouldReturn('Shippingable goods');
    }

    function it_has_no_description_by_default()
    {
        $this->getDescription()->shouldReturn(null);
    }

    function its_description_is_mutable()
    {
        $this->setDescription('All shippingable goods');
        $this->getDescription()->shouldReturn('All shippingable goods');
    }

    function it_initializes_methods_collection_by_default()
    {
        $this->getMethods()->shouldHaveType('Doctrine\Common\Collections\Collection');
    }

    /**
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingMethodInterface $shippingMethod
     */
    function it_adds_methods($shippingMethod)
    {
        $this->hasMethod($shippingMethod)->shouldReturn(false);

        $shippingMethod->setCategory($this)->shouldBeCalled();
        $this->addMethod($shippingMethod);

        $this->hasMethod($shippingMethod)->shouldReturn(true);
    }

    /**
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingMethodInterface $shippingMethod
     */
    function it_removes_methods($shippingMethod)
    {
        $this->hasMethod($shippingMethod)->shouldReturn(false);

        $shippingMethod->setCategory($this)->shouldBeCalled();
        $this->addMethod($shippingMethod);

        $shippingMethod->setCategory(null)->shouldBeCalled();
        $this->removeMethod($shippingMethod);

        $this->hasMethod($shippingMethod)->shouldReturn(false);
    }

    function it_initializes_creation_date_by_default()
    {
        $this->getCreatedAt()->shouldHaveType('DateTime');
    }

    function it_has_no_last_update_date_by_default()
    {
        $this->getUpdatedAt()->shouldReturn(null);
    }
}
