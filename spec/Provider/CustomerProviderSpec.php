<?php

declare(strict_types=1);

namespace spec\Sylius\ShopApiPlugin\Provider;

use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\ShopApiPlugin\Provider\CustomerProviderInterface;

final class CustomerProviderSpec extends ObjectBehavior
{
    function let(CustomerRepositoryInterface $customerRepository, FactoryInterface $customerFactory): void
    {
        $this->beConstructedWith($customerRepository, $customerFactory);
    }

    function it_is_customer_provider(): void
    {
        $this->shouldImplement(CustomerProviderInterface::class);
    }

    function it_provides_customer_from_reposiotory(CustomerRepositoryInterface $customerRepository, CustomerInterface $customer): void
    {
        $customerRepository->findOneBy(['email' => 'example@customer.com'])->willReturn($customer);

        $this->provide('example@customer.com')->shouldReturn($customer);
    }

    function it_creates_new_customer_if_it_does_not_exists(
        CustomerRepositoryInterface $customerRepository,
        FactoryInterface $customerFactory,
        CustomerInterface $customer
    ): void {
        $customerRepository->findOneBy(['email' => 'example@customer.com'])->willReturn(null);
        $customerFactory->createNew()->willReturn($customer);

        $customer->setEmail('example@customer.com')->shouldBeCalled();
        $customerRepository->add($customer)->shouldBeCalled();

        $this->provide('example@customer.com')->shouldReturn($customer);
    }
}
