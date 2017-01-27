# Konekt AppShell

Konekt AppShell is a [Concord box](https://github.com/artkonekt/concord/blob/master/docs/boxes.md) that serves as a foundation for Laravel business applications.

Incorporates the basics for:

- Users and their profiles
- Authentication
- Clients
- Impersonation
- Extensible Admin Interface

The user/auth part is built on top of the Laravel facilities in a compatible manner.

## Built-in Facilities

### Menu

The menu functionality is built on top of [Lavary Menu Component](https://github.com/lavary/laravel-menu). The component is automatically loaded, is fully available (incl. the `Menu` facade).

AppShell creates a menu named **appshellMenu** which is the main menu component, and is available in views as `$appshellMenu`.

