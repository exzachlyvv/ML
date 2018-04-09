<?php

use Rubix\Engine\LeastSquares;
use Rubix\Engine\SupervisedDataset;
use PHPUnit\Framework\TestCase;

class LeastSquaresTest extends TestCase
{
    protected $estimator;

    protected $dataset;

    public function setUp()
    {
        $this->dataset = SupervisedDataset::fromIterator([
            [4, 91.0, 1795, 33.0],
            [6, 225.0, 3651, 20.0],
            [6, 250.0, 3574, 18.0],
            [6, 250.0, 3645, 18.5],
            [6, 258.0, 3193, 17.5],
            [4, 97.0, 1825, 29.5],
            [4, 85.0, 1990, 32.0],
            [4, 87.0, 2155, 28.0],
            [4, 130.0, 3150, 20.0],
            [8, 318.0, 3940, 13.0],
            [4, 120.0, 3270, 19.0],
            [8, 260.0, 3365, 19.9],
        ]);

        $this->estimator = new LeastSquares();

        $this->estimator->train($this->dataset);
    }

    public function test_create_tree()
    {
        $this->assertInstanceOf(LeastSquares::class, $this->estimator);
    }

    public function test_make_prediction()
    {
        $prediction = $this->estimator->predict([6, 150.0, 2825]);

        $this->assertEquals(24.8, round($prediction->outcome(), 1));
    }
}
