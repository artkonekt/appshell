<?php

declare(strict_types=1);

/**
 * Contains the Invitation class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-21
 *
 */

namespace Konekt\AppShell\Models;

use Konekt\Acl\Traits\HasRoles;
use Konekt\User\Models\Invitation as BaseInvitation;

/**
 * @property InvitationStatus $status
 */
class Invitation extends BaseInvitation
{
    use HasRoles;

    protected $guard_name = 'web';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->guard_name = $this->getDefaultGuardName();
    }

    public function getStatusAttribute(): InvitationStatus
    {
        if($this->isStillValid()) {
            return InvitationStatus::ACTIVE();
        } elseif ($this->isExpired()) {
            return InvitationStatus::EXPIRED();
        } elseif ($this->hasBeenUtilizedAlready()) {
            return InvitationStatus::UTILIZED();
        }

        return InvitationStatus::INVALID();
    }
}
