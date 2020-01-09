<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Page as BasePage;

/**
 * General page definition.
 */
abstract class Page extends BasePage
{
    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    public static function siteElements()
    {
        return [
            '@table-empty-message'   => '.dataTables_empty',
        ];
    }
}
