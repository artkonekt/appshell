<?php

namespace Konekt\AppShell\Tests;

use Konekt\AppShell\Models\User;

class TestUser extends User
{
    protected $guard_name = 'web';
}
