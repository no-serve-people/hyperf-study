<?php

namespace HyperfTest\Cases;

use App\Controller\IndexController;
use App\Model\User;
use HyperfTest\HttpTestCase;

/**
 * @internal
 * @coversNothing
 */
class IndexTest extends HttpTestCase
{
    public function test2()
    {
        $model = \Hyperf\Utils\ApplicationContext::getContainer()->get(IndexController::class)->test2();
//        var_dump($model);
        $this->assertSame('断言', $model);
    }
}