# Konekt AppShell

[![Travis Build Status](https://img.shields.io/travis/artkonekt/appshell.svg?style=flat-square)](https://travis-ci.org/artkonekt/appshell)
[![Packagist Stable Version](https://img.shields.io/packagist/v/konekt/appshell.svg?style=flat-square&label=stable)](https://packagist.org/packages/konekt/appshell)
[![StyleCI](https://styleci.io/repos/74504388/shield?branch=master)](https://styleci.io/repos/74504388)
[![Packagist downloads](https://img.shields.io/packagist/dt/konekt/appshell.svg?style=flat-square)](https://packagist.org/packages/konekt/appshell)
[![MIT Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)

Konekt AppShell is a Laravel Extension that serves as foundation for Laravel business applications.

- Users & their profiles
- ACL: permissions & roles
- An extensible admin panel
- Breadcrumbs
- Customers
- Addresses, countries, provinces
- User manageable settings
- Icon themes

The user/auth part is built on top of the Laravel facilities in a compatible manner.

AppShell is built on top of [Concord](https://konekt.dev/concord/1.4/overview)
so this package is also a [Concord box](https://konekt.dev/concord/1.4/boxes).

Refer to the [Documentation](https://konekt.dev/appshell/docs) for more details.

## Changes in 2.0

- [X] Remove hardcoded dependency on `home` `login` and `logout` routes
    - [X] home
    - [X] login
    - [X] logout
- [X] Drop Core UI
- [X] Use proper Bootstrap 4.3/4.4 classes
- [X] Proper Theme Support
    - [X] list of available themes
    - [X] theme colors
    - [-] theme assets (won't do)
    - [X] theme saved as preference
- [X] Fix UI url and home route (in breadcrumbs) ambiguity
- [-] Secondary menus (won't do)
