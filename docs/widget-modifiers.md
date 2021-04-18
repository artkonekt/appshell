# Widget Modifiers

Widget modifiers are classes that take input data, apply some
transformation and return a string.

To define new modifiers you need to:

- Create a modifier class that implements the `WidgetModifier` interface;
- Register the modifier class with the `WidgetModifiers` registry.

## Create a Widget Modifier Class

The `WidgetModifier` interface has 2 methods:

```php
public function handle($value): string;
public static function create(array $arguments): WidgetModifier;
```

A modifier class should look like:

```php
use Konekt\AppShell\Contracts\WidgetModifiers;

class TitleCase implements WidgetModifier
{
    public function handle($value): string
    {
        return ucwords($value);
    }

    public static function create(array $arguments): WidgetModifier
    {
        return new static();
    }
}
```

To register, add this to your package/app provider boot method:

```php
\Konekt\AppShell\WidgetModifiers::add('title', TitleCase::class);
```

Afterwards, you can use the modifier at widgets:

```php
$text = Widgets::make('text', ['modifier' => 'title']);
$text->render('Hello I am a title');
// => "Hello I Am A Title"
```
