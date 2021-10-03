# Text Widget

The text widget is the most fundamental one, many other widgets are built on top of it or use it to
render some of their parts. It does what it says, renders a simple text. As stupid as it may sound,
actually there are lots of things you can do with such a simple widget.

## Text Content

The simplest thing to render is a static text:

```php
Widgets::make('text')->render('Hello World');
// => "Hello World"
```

Although you can set a static text to render, widgets are designed to render data from models,
collections, arrays, etc.

The `$model.field` notation allows you to tell the component which field to render:  

```php
$user = User::find(1);
$name = Widgets::make('text', ['text' => '$model.name']);
$name->render($user);
// => "John Doe"

$email = Widgets::make('text', ['text' => '$model.email']);
$email->render($user);
// => 'john@doe.com"
```

The same notation works for arrays as well:

```php
$user = ['name' => 'Pepe Nero', 'email' => 'pepe@nero.it'];

$name = Widgets::make('text', ['text' => '$model.name']);
$name->render($user);
// => "Pepe Nero"

$email = Widgets::make('text', ['text' => '$model.email']);
$email->render($user);
// => "pepe@nero.it"
```

If you don't pass anything as the `text` option, it will default to `$model` which means, the
component will attempt to output the string representation of the data passed to the `render()`
method.

### Using Model Methods as Text

It is also possible to invoke methods of the model to use the return
value as text to display:

```php
$user = User::find(1);
$name = Widgets::make('text', ['text' => '$model.getEmailForPasswordReset()']);
$name->render($user);
// => 'jane@roe.com"
```

### Using Multiple Model Fields as Text 

It is also possible to add multiple fields/methods to the text:

```php
$user = User::find(1);
$name = Widgets::make('text', ['text' => '$model.name has email: $model.getEmailForPasswordReset()']);
$name->render($user);
// => 'Jane has email: jane@roe.com"
```

## Wrapping

To wrap your text into html tags, pass the wrap option:

```php
$span = Widgets::make('text', ['wrap' => 'span']);
$span->render('43 years old');
// => "<span>43 years old</span>"

$div = Widgets::make('text', ['wrap' => 'div']);
$div->render('Hello');
// => "<div>Hello</div>"
```

## Modifying Content

To manipulate the output of the text itself, you can pass modifiers.
There are built in modifiers, you can define your own ones, or you can
pass PHP callables for simple cases.

### Built-in Modifiers

```php
$upper = Widgets::make('text', ['modifier' => 'uppercase']);
$upper->render('hello');
// => "HELLO"

$lower = Widgets::make('text', ['modifier' => 'lowercase']);
$lower->render('HeLLo');
// => "hello"

$bool2Text = Widgets::make('text', ['modifier' => 'bool2text:yes,no']);
$bool2Text->render(true);
// => "yes"

$bool2Text->render(1);
// => "yes"

$bool2Text->render(false);
// => "no"

$bool2Text->render(null);
// => "no"
```

### Callable Modifers

As long as a callable is taking a single argument, and it returns a
string, simple php function names can be used as modifiers:

```php
$ucText = Widgets::make('text', ['modifier' => 'ucwords']);
$ucText->render('i should be a sentence.');
// => "I Should Be A Sentence."
```

### Extended Modifiers

You can register widget modifiers using the `WidgetModifiers::add()` method.
For more details see the [Widget Modifiers section](widget-modifiers.md).

## Prefix and Suffix

To append or prepend some text to the model's value use the prefix/suffix options:

**Prefix**:

```php
$text = Widgets::make('text', ['text' => '$model.created_at', 'prefix' => 'Member since: ']);
$user = User::find(1);
$text->render($user);
// => "Member since: 2018-05-03 07:13:54"
```

**Suffix**:

```php
$text = Widgets::make('text', ['text' => '$model.login_count', 'suffix' => ' logins']);
$user = User::find(1);
$text->render($user);
// => "1192 logins"
```

## Bold Text

Bolding text can be done with wrapping the text in a `<strong>` tag. But themes and frontend
frameworks have sometimes different approach to achieve this. To support this, the bold option can
be passed, and themes can define themselves how they want to achieve it:

```php
$bold = Widgets::make('text', ['bold' => true]);
$bold->render('tiny');
// => "<span class="font-weight-bold">tiny</span>" (default, bootstrap theme)
```

