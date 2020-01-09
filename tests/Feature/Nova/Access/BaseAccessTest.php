<?php

namespace Tests\Feature\Nova\Access;

use App\Models\User;
use Tests\TestCase;

/**
 * The base access test.
 */
abstract class BaseAccessTest extends TestCase
{
    /**
     * Performs the request to the resource index.
     *
     * @param User   $user
     * @param string $resourceName
     * @param bool   $isAllowed
     */
    protected function assertAccess(User $user, string $resourceName, bool $isAllowed)
    {
        $response = $this
            ->actingAs($user)
            ->getJson('/nova/resources/' . $resourceName);

        if ($isAllowed) {
            $response->assertOk();

            return;
        }

        $response->assertForbidden();
    }
}
