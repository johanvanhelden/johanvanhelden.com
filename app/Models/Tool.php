<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Tool extends Model implements Sortable
{
    use HasFactory, Publishable, SortableTrait, LogsActivity;

    public static bool $logFillable = true;

    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'image',
        'url',
    ];

    /** @var array<string, string|bool> */
    public $sortable = [
        'order_column_name'  => 'order',
        'sort_when_creating' => true,
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept([
                'updated_at',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getImageUrlAttribute(): string
    {
        return Storage::disk('tools')->url($this->image);
    }
}
