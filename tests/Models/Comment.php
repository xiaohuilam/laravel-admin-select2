<?php

namespace LaravelAdminExt\Select2\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelAdminExt\Select2\Interfaces\MorphSelectInterface;

/**
 * 讨论
 *
 * @property integer                  $id
 * @property string                   $commentable_type 墨菲类
 * @property string                   $commentable_id   墨菲ID
 * @property string                   $content          评论内容
 * @property Ansewer|Comment          $commentable      被关注的对象
 * @property Carbon                   $created_at
 * @property Carbon                   $updated_at
 * @property Carbon                   $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereUserId($value)
 */
class Comment extends Model implements MorphSelectInterface
{
    use SoftDeletes;

    protected $fillable = ['content', 'user_id', ];

    /**
     * 被讨论的对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * {@inheritDoc}
     */
    public static function getTextColumn()
    {
        return 'content';
    }
}
