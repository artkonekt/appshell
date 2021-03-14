# Widget Filters

Widget filters are classes that take input data, apply some transformation and return a string.

To define new filters you need to:

- Create a filter class that implements the `WidgetFilter` interface;
- Register the filter class with the `WidgetFilters` registry.

## Create a Widget Filter Class

The `WidgetFilter` interface has 2 methods:

```php
public function handle($value): string;
public static function create(array $arguments): WidgetFilter;
```

A filter class should look like:

```php
use Konekt\AppShell\Contracts\WidgetFilter;

class TitleCase implements WidgetFilter
{
    public function handle($value): string
    {
        return ucwords($value);
    }

    public static function create(array $arguments): WidgetFilter
    {
        return new static();
    }
}
```

To register, add this to your package/app provider boot method:

```php
\Konekt\AppShell\WidgetFilters::add('title', TitleCase::class);
```

Afterwards, you can use the filter at widgets:

```php
$text = Widgets::make('text', ['filter' => 'title']);
$text->render('Hello I am a title');
// => "Hello I Am A Title"
```
