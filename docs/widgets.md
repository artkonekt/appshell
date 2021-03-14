# Widgets

Beginning with AppShell v2.3, rendering of views can happen with the help of widgets. Using of
widgets will be the fundamental paradigm shift of AppShell v3, and it's being introduced in v2 in
order to support the gradual upgrade.

## Widget Basics

Widgets are atomic UI components eg. text controls, checkboxes, badges, etc that are defined in a
frontend agnostic way. Each theme can implement their own variant of these widgets. As a consequence,
AppShell is no longer coupled with Bootstrap or any other frontend framework. Specific themes can
use any frontend framework they want as long as they implement the widgets.

The structure of widgets is defined in the backend, eg.: the user edit controller defines that it
wants to render a form that contains an text edit for the username, another for email, etc.

The widget will be rendered by the active theme. The backend based definition also gives the
opportunity for plugins to extend the predefined widget sets, with the most typical example to add
elements to an existing form.

## Built-in Widgets

AppShell comes with several predefined widgets:

- Badge
- Link
- Text
- MultiText
- ShowDate
- ShowDateTime
- ShowTime
- Table
