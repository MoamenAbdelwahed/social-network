<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class socialNetworkSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('socialNetwork');
    }
}
