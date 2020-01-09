<?php

namespace Tests\Feature\Nova\Access;

use Tests\Helpers\User;

/**
 * Tests to ensure the tools can be accessed properly in Nova.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class ToolTest extends BaseAccessTest
{
    /** @test */
    public function an_admin_can_access_them()
    {
        $this->assertAccess(User::getAdmin(), 'tools', true);
    }

    /** @test */
    public function a_user_can_not_access_them()
    {
        $this->assertAccess(User::getUser(), 'tools', false);
    }
}
