<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'cart';
    public $timestamps=false;
}