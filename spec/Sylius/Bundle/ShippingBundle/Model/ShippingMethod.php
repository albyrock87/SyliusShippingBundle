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

use Doctrine\Common\Collections\ArrayCollection;
use PHPSpec2\ObjectBehavior;
use Sylius\Bundle\ShippingBundle\Model\ShippingMethodInterface;

/**
 * Shipping method model spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ShippingMethod extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\ShippingBundle\Model\ShippingMethod');
    }

    function it_implements_Sylius_shipping_method_interface()
    {
        $this->shouldImplement('Sylius\Bundle\ShippingBundle\Model\ShippingMethodInterface');
    }

    function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_is_enabled_by_default()
    {
        $this->shouldBeEnabled();
    }

    function it_allows_disabling_itself()
    {
        $this->setEnabled(false);
        $this->shouldNotBeEnabled();
    }

    function it_does_not_belong_to_category_by_default()
    {
        $this->getCategory()->shouldReturn(null);
    }

    /**
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface $category
     */
    function it_allows_assigning_itself_to_category($category)
    {
        $this->setCategory($category);
        $this->getCategory()->shouldReturn($category);
    }

    /**
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface $category
     */
    function it_allows_detaching_itself_from_category($category)
    {
        $this->setCategory($category);
        $this->getCategory()->shouldReturn($category);

        $this->setCategory(null);
        $this->getCategory()->shouldReturn(null);
    }

    function it_has_match_any_category_requirement_by_default()
    {
        $this->getCategoryRequirement()->shouldReturn(ShippingMethodInterface::CATEGORY_REQUIREMENT_MATCH_ANY);
    }

    function its_category_matching_requirement_is_mutable()
    {
        $this->setCategoryRequirement(ShippingMethodInterface::CATEGORY_REQUIREMENT_MATCH_NONE);
        $this->getCategoryRequirement()->shouldReturn(ShippingMethodInterface::CATEGORY_REQUIREMENT_MATCH_NONE);
    }

    /**
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingSubjectInterface $subject
     */
    function it_throws_exception_if_disabled_and_trying_to_check_support_for_subject($subject)
    {
        $this->setEnabled(false);
        $this
            ->shouldThrow('LogicException')
            ->duringSupports($subject)
        ;
    }

    /**
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingSubjectInterface $subject
     */
    function it_supports_any_subject_if_there_is_no_category_defined($subject)
    {
        $this->supports($subject)->shouldReturn(true);
    }

    /**
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingSubjectInterface  $subject
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface $category1
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface $category2
     * @param Sylius\Bundle\ShippingBundle\Model\ShippableInterface        $shippable1
     * @param Sylius\Bundle\ShippingBundle\Model\ShippableInterface        $shippable2
     */
    function it_supports_subject_if_none_of_items_has_same_category_when_requirement_says_so(
        $subject, $category1, $category2, $shippable1, $shippable2
    )
    {
        $this->setCategory($category1);
        $this->setCategoryRequirement(ShippingMethodInterface::CATEGORY_REQUIREMENT_MATCH_NONE);

        $shippable1->getCategory()->willReturn($category2);
        $shippable2->getCategory()->willReturn($category2);

        $subject->getShippables()->willReturn(array($shippable1, $shippable2));

        $this->supports($subject)->shouldReturn(true);
    }

    /**
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingSubjectInterface  $subject
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface $category1
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface $category2
     * @param Sylius\Bundle\ShippingBundle\Model\ShippableInterface        $shippable1
     * @param Sylius\Bundle\ShippingBundle\Model\ShippableInterface        $shippable2
     */
    function it_does_not_support_subject_if_any_of_items_has_same_category_when_requirement_says_so(
        $subject, $category1, $category2, $shippable1, $shippable2, $shippable3
    )
    {
        $this->setCategory($category1);
        $this->setCategoryRequirement(ShippingMethodInterface::CATEGORY_REQUIREMENT_MATCH_NONE);

        $shippable1->getShippingCategory()->willReturn($category2);
        $shippable2->getShippingCategory()->willReturn($category1);

        $subject->getShippables()->willReturn(array($shippable1, $shippable2));

        $this->supports($subject)->shouldReturn(false);
    }

    /**
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingSubjectInterface  $subject
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface $category1
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface $category2
     * @param Sylius\Bundle\ShippingBundle\Model\ShippableInterface        $shippable1
     * @param Sylius\Bundle\ShippingBundle\Model\ShippableInterface        $shippable2
     */
    function it_supports_subject_if_any_of_items_has_same_category_when_requirement_says_so(
        $subject, $category1, $category2, $shippable1, $shippable2
    )
    {
        $this->setCategory($category1);
        $this->setCategoryRequirement(ShippingMethodInterface::CATEGORY_REQUIREMENT_MATCH_ANY);

        $shippable1->getShippingCategory()->willReturn($category2);
        $shippable2->getShippingCategory()->willReturn($category1);

        $subject->getShippables()->willReturn(array($shippable1, $shippable2));

        $this->supports($subject)->shouldReturn(true);
    }

    /**
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingSubjectInterface  $subject
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface $category1
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface $category2
     * @param Sylius\Bundle\ShippingBundle\Model\ShippableInterface        $shippable1
     * @param Sylius\Bundle\ShippingBundle\Model\ShippableInterface        $shippable2
     */
    function it_does_not_support_subject_if_none_of_items_has_same_category_when_requirement_says_so(
        $subject, $category1, $category2, $shippable1, $shippable2, $shippable3
    )
    {
        $this->setCategory($category1);
        $this->setCategoryRequirement(ShippingMethodInterface::CATEGORY_REQUIREMENT_MATCH_ANY);

        $shippable1->getShippingCategory()->willReturn($category2);
        $shippable2->getShippingCategory()->willReturn($category2);

        $subject->getShippables()->willReturn(array($shippable1, $shippable2));

        $this->supports($subject)->shouldReturn(false);
    }

    /**
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingSubjectInterface  $subject
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface $category1
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface $category2
     * @param Sylius\Bundle\ShippingBundle\Model\ShippableInterface        $shippable1
     * @param Sylius\Bundle\ShippingBundle\Model\ShippableInterface        $shippable2
     */
    function it_supports_subject_if_all_of_items_have_same_category_when_requirement_says_so(
        $subject, $category1, $category2, $shippable1, $shippable2
    )
    {
        $this->setCategory($category1);
        $this->setCategoryRequirement(ShippingMethodInterface::CATEGORY_REQUIREMENT_MATCH_ALL);

        $shippable1->getShippingCategory()->willReturn($category1);
        $shippable2->getShippingCategory()->willReturn($category1);

        $subject->getShippables()->willReturn(array($shippable1, $shippable2));

        $this->supports($subject)->shouldReturn(true);
    }

    /**
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingSubjectInterface  $subject
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface $category1
     * @param Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface $category2
     * @param Sylius\Bundle\ShippingBundle\Model\ShippableInterface        $shippable1
     * @param Sylius\Bundle\ShippingBundle\Model\ShippableInterface        $shippable2
     */
    function it_does_not_support_subject_if_any_of_items_has_different_category_when_requirement_says_so(
        $subject, $category1, $category2, $shippable1, $shippable2
    )
    {
        $this->setCategory($category1);
        $this->setCategoryRequirement(ShippingMethodInterface::CATEGORY_REQUIREMENT_MATCH_ALL);

        $shippable1->getShippingCategory()->willReturn($category1);
        $shippable2->getShippingCategory()->willReturn($category2);

        $subject->getShippables()->willReturn(new ArrayCollection(array($shippable1, $shippable2)));

        $this->supports($subject)->shouldReturn(false);
    }

    function it_is_unnamed_by_default()
    {
        $this->getName()->shouldReturn(null);
    }

    function its_name_is_mutable()
    {
        $this->setName('Shippable goods');
        $this->getName()->shouldReturn('Shippable goods');
    }

    function it_is_convertable_to_string_and_uses_its_name_for_this()
    {
        $this->setName('Shippable goods');
        $this->__toString()->shouldReturn('Shippable goods');
    }

    function it_has_no_calculator_defined_by_default()
    {
        $this->getCalculator()->shouldReturn(null);
    }

    function its_calculator_is_mutable()
    {
        $this->setCalculator('default');
        $this->getCalculator()->shouldReturn('default');
    }

    function it_initializes_array_for_configuration_by_default()
    {
        $this->getConfiguration()->shouldReturn(array());
    }

    function its_configuration_is_mutable()
    {
        $this->setConfiguration(array('charge' => 5));
        $this->getConfiguration()->shouldReturn(array('charge' => 5));
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
