<?php

namespace Tests\Unit;

use App\StringCompare;
use PHPUnit\Framework\TestCase;

class StringCompareTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function it_should_compare_to_strings()
    {
        $compare = new StringCompare('Victor Hernandez');
        $this->assertEquals(100, $compare->compare('Victor Hernandez'));
    }

    /**
     * @test
     */
    public function sensitivity_does_not_matter()
    {
        $compare = new StringCompare('victor hernandez');
        $this->assertEquals(100, $compare->compare('Victor Hernandez'));
    }

    /**
     * @test
     */
    public function order_does_not_matter()
    {
        $compare = new StringCompare('Hernandez Victor');
        $this->assertEquals(100, $compare->compare( 'Victor Hernandez'));
    }

    /**
     * @test
     */
    public function it_should_get_similar_string()
    {
        $compare = new StringCompare('Biviana Sarik');
        $this->assertEquals('viviana zarick', $compare->getSimularString( 'biviana sarick'));
    }

    /**
     * @test
     * @dataProvider names
     */
    public function it_should_compare_names_with_all_restrictions($name, $compare_name ,$expected_rate)
    {
        $compare = new StringCompare($name);
        $this->assertEquals($expected_rate, floor($compare->compare($compare_name)));
    }

    public function names()
    {
        return [
          ['Juan Luis  goovaerts', 'Juan Luis Guerra', 74],
          ['Goovaerts Juan Luis', 'Juan Luis Guerra', 74],
          ['Guerra Juan Luis', 'Juan Luis Guerra', 100],
          ['Viviana', 'Biviana', 100],
          ['Zarick Viviana', 'Sarick Biviana', 100],
          ['Juan luis GoOvaerts', 'juan luis goovaerts', 100],
        ];
    }
}
