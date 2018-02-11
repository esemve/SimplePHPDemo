<?php

namespace Libs;

class ArrayAssert
{
    /**
     * @param array $array
     * @param bool $throwException
     * @return bool
     * @throws \Exception
     */
    static function hasOnlyString(array $array = [], bool $throwException = false): bool
    {
        foreach ($array as $value) {
            if (!is_string($value)) {
                if ($throwException) {
                    throw new \Exception('A tömb csak stringeket tartalmazhat!');
                }
                return false;
            }
        }

        return true;
    }
}