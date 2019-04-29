<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use CyrildeWit\EloquentViewable\Viewable;
use CyrildeWit\EloquentViewable\Contracts\Viewable as ViewableContract;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Chapter extends Model implements ViewableContract
{
    use SoftDeletes, Viewable, CascadeSoftDeletes;

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deteted_at',
    ];

    protected $cascadeDeletes = [
        'comments',
        'votes'
    ];
    
    public function scopePublished($q)
    {
        return $q->where('chapters.status', self::STATUS_PUBLISHED);
    }

    public function getIsPublishedAttribute()
    {
        return $this->status == self::STATUS_PUBLISHED;
    }

    // Other methods
    public function delete()
    {
        $this->comments()->delete();
        $this->votes()->delete();
        parent::delete();
    }

    // Relationships
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->where('parent_id', 0);
    }

    public function story()
    {
        return $this->belongsTo('App\Models\Story', 'story_id');
    }

    public function votes()
    {
        return $this->morphMany('App\Models\Vote', 'votable');
    }
}
