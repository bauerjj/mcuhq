<?php

namespace Hazzard\Comments;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'comment_id' => 'integer',
    ];

    /**
     * Create a new model instance.
     *
     * @param  array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('comments.table_names.reports'));
    }

    /**
     * Get the report comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function comment()
    {
        return $this->belongsTo(config('comments.models.comment'));
    }
}
