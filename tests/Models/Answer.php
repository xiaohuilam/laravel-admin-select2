<?php

namespace LaravelAdminExt\Select2\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelAdminExt\Select2\Interfaces\MorphSelectInterface;

/**
 * 答案
 *
 * @property integer    $id
 * @property integer    $question_id 问题ID
 * @property string     $content     回答内容
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereUserId($value)
 */
class Answer extends Model implements MorphSelectInterface
{
    use SoftDeletes;

    protected $fillable = [
        'content',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * {@inheritDoc}
     */
    public static function getTextColumn()
    {
        return 'content';
    }
}
