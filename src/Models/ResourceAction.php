<?php

namespace Konekt\AppShell\Models;

use Konekt\Enum\Enum;

class ResourceAction extends Enum
{
    public const INDEX = 'index';
    public const CREATE = 'create';
    public const STORE = 'store';
    public const SHOW = 'show';
    public const EDIT = 'edit';
    public const UPDATE = 'update';
    public const DESTROY = 'destroy';

}
