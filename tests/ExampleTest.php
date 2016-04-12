<?php

namespace Spatie\Url\Test;

use Spatie\Url\ParameterBag;

class ParameterBagTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_initializable()
    {
        $this->assertInstanceOf(ParameterBag::class, new ParameterBag([]));
    }

    /** @test */
    public function it_can_be_created_from_a_string()
    {
        $this->assertInstanceOf(ParameterBag::class, ParameterBag::fromString(''));
    }

    /** @test */
    public function it_parses_a_simple_key_value_pair()
    {
        $this->assertEquals(
            ['kendrick' => 'k-dot'],
            ParameterBag::fromString('kendrick=k-dot')->all()
        );
    }

    /** @test */
    public function it_parses_multiple_key_value_pairs()
    {
        $this->assertEquals(
            ['kendrick' => 'k-dot', 'kanye' => 'ye'],
            ParameterBag::fromString('kendrick=k-dot&kanye=ye')->all()
        );
    }

    /** @test */
    public function it_uses_the_last_key_if_there_are_duplicates()
    {
        $this->assertEquals(
            ['kanye' => 'yeezy'],
            ParameterBag::fromString('kanye=ye&kanye=yeezy')->all()
        );
    }

    /** @test */
    public function it_parses_an_empty_query_string()
    {
        $this->assertEquals([], ParameterBag::fromString('')->all());
    }
}
