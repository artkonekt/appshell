# Link Widget

The link can be used to display a link. It is the extension of the
[Text Widget](widget-text.md) therefore text widget options can be used
for rendering links.

## Usage

The most simple way to render a link is the usage of a static text and url:

```php
$link = Widgets::make('link', ['url' => 'https://protonmail.com']);

$link->render('Gmail Alternative with Privacy');
// <a href="https://protonmail.com">Gmail Alternative with Privacy</a>
```

### Based on Model Fields

It is possible to use the `$model.field` notation:

```php
$link = Widgets::make('link', ['text' => '$model.title', 'url' => '$model.link']);

$document = Document::create(['title' => 'Users Guide', 'link' => 'https://bit.ly/xyz']);
$link->render($document);
// <a href="https://bit.ly/xyz">Users Guide</a>
```

### Using Named Routes

It is possible to use Laravel named routes and pass route parameters

```php
$link = Widgets::make('link', [
    'text' => '$model.name',
    'url' => [
        'route' => 'admin.users.edit',
        'parameters' => ['$model'],
    ]
]);

$user = User::find(1);
$link->render($user);
// <a href="https://localhost/users/edit/1">Joe Bloggs</a>
```

### Resolving URLs via Laravel

It is possible to pass the link through Laravel's `url()` helper:

```php
$link = Widgets::make('link', [
    'text' => '$model.name',
    'url' => [
        'path' => '/show/user',
        'parameters' => ['$model.id'],
    ]
]);

$user = User::find(1);
$link->render($user);
// <a href="https://localhost/users/show/1">Joe Bloggs</a>
```

The model can also be an array:

```php
$link = Widgets::make('link', ['text' => '$model.caption', 'url' => '$model.path']);
$data = ['caption' => 'Imbox', 'url' => 'https://hey.com'];
$link->render($data);
// <a href="https://hey.com">Imbox</a>
```

### HTML Tweaks

The inner text of the link can be configured the same way as the
[text widgets](widget-text.md).

It is possible to define a wrapper html tag:

```php
$link = Widgets::make('link', [
    'text' => [
        'text' => 'Signal',
        'wrap' => 'span',
    ],
    'url' => 'https://signal.org',
]);

$link->render();
// <a href="https://signal.org"><span>Signal</span></a>
```

Classes can also be added to the inner text:

```php
$link = Widgets::make('link', [
    'text' => [
        'text' => 'Signal',
        'wrap' => 'span',
        'class' => 'text-muted',
    ],
    'url' => 'https://signal.org',
]);

$link->render();
// <a href="https://signal.org"><span class="text-muted">Signal</span></a>
```

### Conditional Links

It is possible to only render links if they are allowed by the
[Laravel Authorization subsystem](https://laravel.com/docs/8.x/authorization#authorizing-actions-using-policies)
ie. the `can()` method:

```php
$link = Widgets::make('link', [
    'text' => 'Customers',
    'url' => 'https://app.url/customers',
    'onlyIfCan' => 'view customers'
]);
```

If the `Auth::user()->can('view customers')` method returns true, the
link will be rendered. If not, then only the text, without the link.
