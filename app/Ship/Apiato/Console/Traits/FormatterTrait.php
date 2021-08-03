<?php

namespace App\Ship\Apiato\Console\Traits;

trait FormatterTrait
{

    /**
     * @param $string
     *
     * @return  string
     */
    protected function trimString($string)
    {
        return trim($string);
    }


    /**
     * @param $word
     *
     * @return  string
     */
    public function capitalize($word)
    {
        return ucfirst($word);
    }


    /**
     * @param $operation
     * @param $class
     *
     * @return  string
     */
    public function prependOperationToName($operation, $class)
    {
        $className = $class;

        return $operation . $this->capitalize($className);
    }
}
