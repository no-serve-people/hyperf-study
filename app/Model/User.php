<?php

declare(strict_types=1);

namespace App\Model;


use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use Hyperf\ModelCache\Cacheable;
use Hyperf\ModelCache\CacheableInterface;

/**
 * @property $id
 * @property $name
 * @property $gender
 * @property $created_at
 * @property $updated_at
 */
class User extends Model implements CacheableInterface
{
    use Cacheable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    // 关闭时间戳
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'gender', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'gender' => 'integer'];

    /**
     * @param $id
     * @param bool $throw
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Builder[]|\Hyperf\Database\Model\Collection|\Hyperf\Database\Model\Model|null
     */
    public function first($id, $throw = true)
    {
        $model = self::query()->find($id);
        if ($throw && empty($model)) {
            throw new BusinessException(ErrorCode::USER_NOT_EXIST);
        }
        return $model;
    }
}
