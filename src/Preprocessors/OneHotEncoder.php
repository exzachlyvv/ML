<?php

namespace Rubix\Engine\Preprocessors;

use Rubix\Engine\Dataset;

class OneHotEncoder implements Preprocessor
{
    /**
     * The set of unique possible categories of the training set.
     *
     * @var array
     */
    protected $categories = [
        //
    ];

    /**
     * The column types of the fitted dataset. i.e. categorical or continuous.
     *
     * @var array
     */
    protected $columnTypes = [
        //
    ];

    /**
     * Build the list of categories.
     *
     * @param  \Rubix\Engine\Dataset  $data
     * @return void
     */
    public function fit(Dataset $data) : void
    {
        $this->columnTypes = $data->columnTypes();

        foreach ($data->samples() as $sample) {
            foreach ($this->columnTypes as $column => $type) {
                if ($type === self::CATEGORICAL) {
                    if (!isset($this->categories[$sample[$column]])) {
                        $this->categories[$sample[$column]] = count($this->categories);
                    }
                }
            }
        }
    }

    /**
     * Transform the categorical features into binary encoded vectors.
     *
     * @param  array  $samples
     * @return void
     */
    public function transform(array &$samples) : void
    {
        foreach ($samples as &$sample) {
            $sample = $this->encode($sample);
        }
    }

    /**
     * Convert a sample into a vector where categorical values are either 1 or 0
     * depending if a category is present in the sample or not. Continuous data,
     * if present, is left untouched but it is moved to the front of the vector.
     *
     * @param  string  $sample
     * @return array
     */
    public function encode(array $sample) : array
    {
        $vector = array_fill_keys($this->categories, 0);

        foreach ($sample as $column => $feature) {
            if ($this->columnTypes[$column] === self::CATEGORICAL) {
                if (isset($this->categories[$feature])) {
                    $vector[$this->categories[$feature]] = 1;
                }

                unset($sample[$column]);
            }
        }

        return array_merge($sample, $vector);
    }
}
