<?php

Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push(__('Home'), route('home'));
});

Breadcrumbs::register('appshell.user.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Users'), route('appshell.user.index'));
});

Breadcrumbs::register('appshell.user.create', function ($breadcrumbs) {
    $breadcrumbs->parent('appshell.user.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::register('appshell.user.show', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('appshell.user.index');
    $breadcrumbs->push($user->name, route('appshell.user.show', $user));
});

Breadcrumbs::register('appshell.user.edit', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('appshell.user.show', $user);
    $breadcrumbs->push(__('Edit'), route('appshell.user.edit', $user));
});

Breadcrumbs::register('appshell.role.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Permissions'), route('appshell.role.index'));
});

Breadcrumbs::register('appshell.role.create', function ($breadcrumbs) {
    $breadcrumbs->parent('appshell.role.index');
    $breadcrumbs->push(__('Create role'));
});

Breadcrumbs::register('appshell.role.show', function ($breadcrumbs, $role) {
    $breadcrumbs->parent('appshell.role.index');
    $breadcrumbs->push(__(':name role', ['name' => $role->name]), route('appshell.role.show', $role));
});

Breadcrumbs::register('appshell.role.edit', function ($breadcrumbs, $role) {
    $breadcrumbs->parent('appshell.role.show', $role);
    $breadcrumbs->push(__('Edit'), route('appshell.role.edit', $role));
});

Breadcrumbs::register('appshell.customer.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Customers'), route('appshell.customer.index'));
});

Breadcrumbs::register('appshell.customer.show', function ($breadcrumbs, $customer) {
    $breadcrumbs->parent('appshell.customer.index');
    $breadcrumbs->push(__(':name', ['name' => $customer->name]), route('appshell.customer.show', $customer));
});

Breadcrumbs::register('appshell.customer.edit', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('appshell.customer.show', $user);
    $breadcrumbs->push(__('Edit'), route('appshell.customer.edit', $user));
});

Breadcrumbs::register('appshell.customer.create', function ($breadcrumbs) {
    $breadcrumbs->parent('appshell.customer.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::register('appshell.settings.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Settings'));
});

Breadcrumbs::register('appshell.address.create', function ($breadcrumbs) {
    $breadcrumbs->parent('appshell.customer.index');
    $breadcrumbs->push(__('Create address'));
});
