<?php

namespace Tests\Feature\Nova\Access;

use Tests\Helpers\User;

/**
 * Tests to ensure the roles can be accessed properly in Nova.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class RoleTest extends BaseAccessTest
{
    /** @test */
    public function an_admin_can_access_them()
    {
        $this->assertAccess(User::getAdmin(), 'roles', true);
    }

    /** @test */
    public function a_user_can_not_access_them()
    {
        $this->assertAccess(User::getUser(), 'roles', false);
    }
}
