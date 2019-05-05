<?php

namespace LaravelAdminExt\Select2\Test\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 讨论
 *
 * @property integer $id
 * @property string  $name
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereId($value)
 */
class Tag extends Model
{
    protected $fillable = ['name',];
}
