# Text Widget

!> Sidebar experiment

Text widget is the most fundamental one, many others are built on top of it. It does what it says,
renders a simple text. As stupid as it may sound, actually there are lots of things you can do with
such a simple widget.

## Content

```php
$options = [
    'text' => '$model.name'
];
$text = Widget::make('text', $options);
view('show_user', ['widget' => $text]);
```

**show_user.blade.php**:

```blade
{!! $widget->render($user) !!}
```
