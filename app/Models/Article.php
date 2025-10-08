<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Article extends Model
{
    use LogsActivity;

    protected $fillable = ['title', 'text', 'author', 'category_id', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('article')
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Article Telah {$eventName}");
    }
}
