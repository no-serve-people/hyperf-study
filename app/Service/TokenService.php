<?php

namespace App\Service;

use App\Exception\TokenException;
use Firebase\JWT\JWT;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class TokenService
{
    public function authorizations(RequestInterface $request)
    {
        $key = config('server.jwt-setting.key', 'xpnaYVqVVDwFfy8A'); //key
        $time = time();
        $token = [
            'iss'  => config('server.jwt-setting.jwtIss', 'chachadian.com'),     // 签发者（可选）
            'aud'  => config('server.jwt-setting.jwtAud', 'chachadian.com'),     // 接收方（可选）
            'iat'  => $time,                             // 签发时间
            'nbf'  => $time,                             // 某个时间点后才能访问
            'exp'  => $time + 7 * 24 * 60 * 60,          // 过期时间
            'data' => $request->all()                             // 自定义信息
        ];
        return JWT::encode($token, $key);
    }

    public function verification($jwt)
    {
        $key = config('server.jwt-setting.key','xpnaYVqVVDwFfy8A'); //key要和签发的时候一样
        try {
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($jwt, $key, ['HS256']); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            return json_encode($arr);
        } catch (\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
            throw new TokenException(-998, $e->getMessage());
        } catch (\Firebase\JWT\BeforeValidException $e) {       // 签名在某个时间点之后才能用
            throw new TokenException(-997, $e->getMessage());
        } catch (\Firebase\JWT\ExpiredException $e) {           // token过期
            throw new TokenException(-996, $e->getMessage());
        } catch (\Throwable $e) {                               //其他错误
            throw new TokenException(-995, $e->getMessage());
        }
        //Firebase定义了多个 throw new，我们可以捕获多个catch来定义问题，catch加入自己的业务，比如token过期可以用当前Token刷新一个新Token
    }
}