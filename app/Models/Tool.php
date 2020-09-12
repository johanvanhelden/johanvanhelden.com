<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Tool extends Model implements Sortable
{
    use HasFactory, Publishable, SortableTrait, LogsActivity;

    public static bool $logFillable = true;

    /** @var array */
    protected $fillable = [
        'name',
        'image',
        'url',
    ];

    /** @var array */
    public $sortable = [
        'order_column_name'  => 'order',
        'sort_when_creating' => true,
    ];
}
