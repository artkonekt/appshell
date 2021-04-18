# Date, Time and DateTime Widgets

There are 3 basic datetime widgets that can be used to display date
and/or time:

- `show_datetime` - to display both date and time
- `show_date` - to display the date without time
- `show_time` - to display the time only, without date

All of them are the extension of the [Text Widget](widget-text.md)
therefore text widget options can be used for rendering dates.

The advantage of these widgets is that they display the dates/times
with the format the users have set on at their own preferences.

## Usage

```php
$widget = Widgets::make('show_datetime');

$widget->render(new DateTime('2023-04-21 11:27:35'));
// 2023-04-21 11:27 (the output format depends on the current user's preferences!)
```

### Based on Model Fields

It is possible to use the `$model.field` notation:

```php
$widget = Widgets::make('show_date', ['text' => '$model.created_at']);

$widget->render(User::find(1));
// 2018-05-01
```

### Adding Prefix

It is possible to use the `$model.field` notation:

```php
$widget = Widgets::make('show_date', [
    'text' => '$model.last_purchase_at',
    'prefix' => __('Last purchase on') . ' '
]);

$widget->render(Customer::find(1));
// Last purchase on 2020-12-27
```


### Fallback Value

In case the given value is not a date it's possible to define

```php
$widget = Widgets::make('show_date', [
    'unknown' => __('never')
]);

$widget->render(null);
// never
```
