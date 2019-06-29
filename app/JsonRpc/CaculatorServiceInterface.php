<?php

namespace App\JsonRpc;

interface CaculatorServiceInterface
{
    public function caculate(int $a, int $b): int;
}