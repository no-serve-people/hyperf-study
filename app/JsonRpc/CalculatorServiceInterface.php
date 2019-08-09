<?php

namespace App\JsonRpc;

interface CalculatorServiceInterface
{
    public function add(int $a, int $b): int;
}