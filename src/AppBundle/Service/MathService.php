<?php

namespace AppBundle\Service;

class MathService
{

    public function addition($num1, $num2)
    {
        return $num1 + $num2;
    }

    public function soustraction($num1, $num2)
    {
        return $num1 - $num2;
    }

    public function produit($num1, $num2)
    {
        return $num1 * $num2;
    }

    public function division($num1, $num2)
    {
        if ($num2 != 0) {
            return $num1 / $num2;
        }
        return 0;
    }
}