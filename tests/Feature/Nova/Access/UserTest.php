<?php

namespace Tests\Feature\Nova\Access;

use Tests\Helpers\User;

/**
 * Tests to ensure the users can be accessed properly in Nova.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class UserTest extends BaseAccessTest
{
    /** @test */
    public function an_admin_can_access_them()
    {
        $this->assertAccess(User::getAdmin(), 'users', true);
    }

    /** @test */
    public function a_user_can_not_access_them()
    {
        $this->assertAccess(User::getUser(), 'users', false);
    }
}
