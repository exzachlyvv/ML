<?php

use Rubix\Engine\Dataset;
use Rubix\Engine\Preprocessors\BlanketCharacterFilter;
use PHPUnit\Framework\TestCase;

class BlanketCharacterFilterTest extends TestCase
{
    protected $preprocessor;

    public function setUp()
    {
        $this->preprocessor = new BlanketCharacterFilter([',']);
    }

    public function test_build_blanket_character_filter()
    {
        $this->assertInstanceOf(BlanketCharacterFilter::class, $this->preprocessor);
    }

    public function test_fit_dataset()
    {
        $this->preprocessor->fit(new Dataset([]));

        $this->assertTrue(true);
    }

    public function test_transform_dataset()
    {
        $data = [
            ['I like cooking, my family, and pets.'],
        ];

        $this->preprocessor->transform($data);

        $this->assertEquals([
            ['I like cooking my family and pets.']
        ], $data);
    }
}
