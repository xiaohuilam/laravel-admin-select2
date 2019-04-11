<?php

namespace LaravelAdminExt\Select2\Test\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelAdminExt\Select2\Interfaces\MorphSelectInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * 答案
 *
 * @property integer    $id
 * @property integer    $question_id 问题ID
 * @property integer    $user_id     作者ID
 * @property string     $content     回答内容
 * @property User       $user        作者
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int $comments_cout
 * @method static bool|null forceDelete()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Answer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Answer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Answer withoutTrashed()
 * @mixin \Eloquent
 */
class Answer extends Model implements MorphSelectInterface
{
    use SoftDeletes;

    protected $fillable = [
        'content',
    ];

    /**
     * {@inheritDoc}
     */
    public static function getTextColumn()
    {
        return 'content';
    }
}
