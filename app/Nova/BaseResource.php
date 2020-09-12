<?php

declare(strict_types=1);

namespace App\Nova;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;

abstract class BaseResource extends NovaResource
{
    public static array $indexDefaultOrder = [
        'id' => 'desc',
    ];

    public static string $translateKey;

    /**
     * Build an "index" query for the given resource.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if (empty($request->get('orderBy'))) {
            $query->getQuery()->orders = [];

            $orderColumn = strval(key(static::$indexDefaultOrder));
            $orderDirection = strval(reset(static::$indexDefaultOrder));

            return $query->orderBy($orderColumn, $orderDirection);
        }

        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     *
     * @param Builder $query
     */
    public static function detailQuery(NovaRequest $request, $query): Builder
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param Builder $query
     *
     * @return Builder|Model
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    }

    public static function label(): string
    {
        return __(static::$translateKey . '.plural');
    }

    public static function singularLabel(): string
    {
        return __(static::$translateKey . '.singular');
    }
}
