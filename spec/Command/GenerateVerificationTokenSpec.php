<?php

declare(strict_types=1);

namespace spec\Sylius\ShopApiPlugin\Command;

use PhpSpec\ObjectBehavior;
use Sylius\ShopApiPlugin\Command\GenerateVerificationToken;

final class GenerateVerificationTokenSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('example@customer.com');
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(GenerateVerificationToken::class);
    }

    function it_has_email(): void
    {
        $this->email()->shouldReturn('example@customer.com');
    }
}
