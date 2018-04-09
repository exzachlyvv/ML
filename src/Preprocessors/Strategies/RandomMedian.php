<?php

namespace Rubix\Engine\Preprocessors\Strategies;

use MathPHP\Statistics\Average;
use InvalidArgumentException;

class RandomMedian implements Continuous
{
    /**
     * The ratio of random samples to consider when deciding the most popular value.
     *
     * @var float
     */
    protected $ratio;

    /**
     * @param  float  $ratio
     * @throws \InvalidArgumentException
     * @return void
     */
    public function __construct(float $ratio = 0.1)
    {
        if ($ratio < 0.0 || $ratio > 1.0) {
            throw new InvalidArgumentException('The ratio of subsamples must be a float between 0 and 1.');
        }

        $this->ratio = $ratio;
    }

    /**
     * Guess a value based on the median of a subsampling of the values.
     *
     * @param  array  $values
     * @return mixed
     */
    public function guess(array $values)
    {
        if (empty($values)) {
            throw new RuntimeException('This strategy requires at least 1 data point.');
        }

        $subset = [];

        foreach (range(1, ceil($this->ratio * count($values))) as $i) {
            $subset[] = $values[array_rand($values)];
        }

        return Average::median($subset);
    }
}
