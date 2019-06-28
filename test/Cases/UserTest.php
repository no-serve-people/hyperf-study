<?php

namespace HyperfTest\Cases;

use App\Model\User;
use HyperfTest\HttpTestCase;

/**
 * @internal
 * @coversNothing
 */
class UserTest extends HttpTestCase
{
    public function testUserDaoFirst()
    {
        $model = \Hyperf\Utils\ApplicationContext::getContainer()->get(User::class)->first(1);
//        var_dump($model);
        $this->assertSame(1, $model->id);
    }
}