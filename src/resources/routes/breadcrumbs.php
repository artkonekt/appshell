<?php

Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push(__('Home'), route('home'));
});

Breadcrumbs::register('appshell.user.index', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Users'), route('appshell.user.index'));
});

Breadcrumbs::register('appshell.user.create', function($breadcrumbs) {
    $breadcrumbs->parent('appshell.user.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::register('appshell.user.show', function($breadcrumbs, $user) {
    $breadcrumbs->parent('appshell.user.index');
    $breadcrumbs->push($user->name, route('appshell.user.show', $user));
});

Breadcrumbs::register('appshell.user.edit', function($breadcrumbs, $user) {
    $breadcrumbs->parent('appshell.user.show', $user);
    $breadcrumbs->push(__('Edit'), route('appshell.user.edit', $user));
});