<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Tool extends Model implements Auditable, Sortable
{
    use AuditTrait, Publishable, SortableTrait;

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
