<?php

declare(strict_types=1);

Breadcrumbs::for('home', function ($breadcrumbs) {
    $breadcrumbs->push(__('Home'), url(config('konekt.app_shell.ui.url')));
});

Breadcrumbs::for('appshell.user.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Users'), route('appshell.user.index'));
});

Breadcrumbs::for('appshell.user.create', function ($breadcrumbs) {
    $breadcrumbs->parent('appshell.user.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('appshell.user.show', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('appshell.user.index');
    $breadcrumbs->push($user->name, route('appshell.user.show', $user));
});

Breadcrumbs::for('appshell.user.edit', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('appshell.user.show', $user);
    $breadcrumbs->push(__('Edit'), route('appshell.user.edit', $user));
});

Breadcrumbs::for('appshell.role.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Permissions'), route('appshell.role.index'));
});

Breadcrumbs::for('appshell.role.create', function ($breadcrumbs) {
    $breadcrumbs->parent('appshell.role.index');
    $breadcrumbs->push(__('Create role'));
});

Breadcrumbs::for('appshell.role.show', function ($breadcrumbs, $role) {
    $breadcrumbs->parent('appshell.role.index');
    $breadcrumbs->push(__(':name role', ['name' => $role->name]), route('appshell.role.show', $role));
});

Breadcrumbs::for('appshell.role.edit', function ($breadcrumbs, $role) {
    $breadcrumbs->parent('appshell.role.show', $role);
    $breadcrumbs->push(__('Edit'), route('appshell.role.edit', $role));
});

Breadcrumbs::for('appshell.customer.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Customers'), route('appshell.customer.index', ['is_active' => 1]));
});

Breadcrumbs::for('appshell.customer.show', function ($breadcrumbs, $customer) {
    $breadcrumbs->parent('appshell.customer.index');
    $breadcrumbs->push(__(':name', ['name' => $customer->name]), route('appshell.customer.show', $customer));
});

Breadcrumbs::for('appshell.customer.edit', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('appshell.customer.show', $user);
    $breadcrumbs->push(__('Edit'), route('appshell.customer.edit', $user));
});

Breadcrumbs::for('appshell.customer.create', function ($breadcrumbs) {
    $breadcrumbs->parent('appshell.customer.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('appshell.settings.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Settings'));
});

Breadcrumbs::for('appshell.address.create', function ($breadcrumbs) {
    $breadcrumbs->parent('appshell.customer.index');
    $breadcrumbs->push(__('Create address'));
});

Breadcrumbs::for('appshell.invitation.index', function ($breadcrumbs) {
    $breadcrumbs->parent('appshell.user.index');
    $breadcrumbs->push(__('Invitations'), route('appshell.invitation.index'));
});

Breadcrumbs::for('appshell.invitation.create', function ($breadcrumbs) {
    $breadcrumbs->parent('appshell.invitation.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('appshell.invitation.show', function ($breadcrumbs, $invitation) {
    $breadcrumbs->parent('appshell.invitation.index');
    $breadcrumbs->push($invitation->email, route('appshell.invitation.show', $invitation));
});

Breadcrumbs::for('appshell.invitation.edit', function ($breadcrumbs, $invitation) {
    $breadcrumbs->parent('appshell.invitation.show', $invitation);
    $breadcrumbs->push(__('Edit'), route('appshell.invitation.edit', $invitation));
});

Breadcrumbs::for('appshell.country.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Countries'), route('appshell.country.index'));
});

Breadcrumbs::for('appshell.country.create', function ($breadcrumbs) {
    $breadcrumbs->parent('appshell.country.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('appshell.country.show', function ($breadcrumbs, $country) {
    $breadcrumbs->parent('appshell.country.index');
    $breadcrumbs->push($country->name, route('appshell.country.show', $country));
});

Breadcrumbs::for('appshell.country.edit', function ($breadcrumbs, $country) {
    $breadcrumbs->parent('appshell.country.show', $country);
    $breadcrumbs->push(__('Edit'), route('appshell.country.edit', $country));
});

Breadcrumbs::for('appshell.province.create', function ($breadcrumbs, $country) {
    $breadcrumbs->parent('appshell.country.show', $country);
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('appshell.province.show', function ($breadcrumbs, $country, $province) {
    $breadcrumbs->parent('appshell.country.show', $country);
    $breadcrumbs->push(__('Provinces'), route('appshell.country.show', $country));
    $breadcrumbs->push($province->name, route('appshell.province.show', [$country, $province]));
});

Breadcrumbs::for('appshell.province.edit', function ($breadcrumbs, $country, $province) {
    $breadcrumbs->parent('appshell.country.show', $country);
    $breadcrumbs->push(__('Provinces'), route('appshell.country.show', $country));
    $breadcrumbs->push($province->name);
    $breadcrumbs->push(__('Edit'), route('appshell.province.edit', [$country, $province]));
});
