<?php

namespace App\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;

/**
 * Defines a Nova resource.
 */
abstract class BaseResource extends NovaResource
{
    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static $indexDefaultOrder = [
        'id' => 'desc',
    ];

    /**
     * Key for the translation group used to get the labels.
     *
     * @var string|null
     */
    public static $translateKey;

    /**
     * Build an "index" query for the given resource.
     *
     * @param NovaRequest                           $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
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
     * Build a Scout search query for the given resource.
     *
     * @param NovaRequest            $request
     * @param \Laravel\Scout\Builder $query
     *
     * @return \Laravel\Scout\Builder
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     *
     * @param NovaRequest                           $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param NovaRequest                           $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __(static::$translateKey . '.plural');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __(static::$translateKey . '.singular');
    }
}
