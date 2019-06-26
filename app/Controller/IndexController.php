<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use Hyperf\HttpServer\Annotation\RequestMapping;
use think\Validate;

/**
 * @\Hyperf\HttpServer\Annotation\Controller()
 */
class IndexController extends Controller
{
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method'  => $method,
            'message' => "Hello {$user}.",
        ];
    }

    /**
     * 测试tp验证器
     * @RequestMapping(path="test2", method="get,post")
     */
    public function test2()
    {
        try {
            $validate = Validate::make([
//                'name'  => 'require|max:25',
                'email' => 'email'
            ]);
            $data = [
//                'name'  => '11',
                'email' => '9999'
            ];
            if (!$validate->check($data)) {
                var_dump($validate->getError());
                return $validate->getError();
            }
        } catch (\Throwable $e) {
            var_dump(111);
            return $e->getMessage();
        }
    }
}
