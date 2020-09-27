# ACL

AppShell has a built in ACL facility supporting permissions and roles.

> The core functionality is built on top of the [konekt/acl](https://konekt.dev/acl) library, which
> is a "concordized" fork of the
> [Spatie Laravel Permissions Library](https://spatie.be/docs/laravel-permission/v2/introduction)

## Permissions and Roles

The most important unit of ACLs is the **permission** which is a capability that can be granted to
users. Permissions are represented as strings and typically look something like:

- "edit products"
- "create users"
- "delete absence types"

**Roles** in turn are groups of permissions that can be assigned to users. If a role is assigned to
a user, then all the permissions in the role are granted to the user.

AppShell was designed to build your app around permissions. This way you use the native Laravel
`@can` and `can()` directives in your app.

Roles can still be used to group permissions for easy assignment, but using the
role-based helper methods is discouraged. Using the permissions and `can` methods leads to a very
Laravel convention-compliant application, that relies on the Gates functionality from Laravel's
built-in [Authorization Layer](https://laravel.com/docs/8.x/authorization).

## Defining Permissions

Permissions are "permanent" entities in the application and not userland data, therefore:

- they are required for your application to work;
- you can "hardcode" them by their names in `can()` calls;
- they must be added to migrations and not to seeders since the code is referencing them.

### Creating Permission Migrations

Each module you create and has ACL protected resources needs to add its permissions to a migration.
It's recommended to dedicate a separated migration for the permission creation:

```php
class CreateProductPermissions extends Migration
{
    private $permissions = [
        'list products',
        'create products',
        'view products',
        'edit products',
        'delete products',        
        'list product types',
        'create product types',
        'view product types',
        'edit product types',
        'delete product types',        
    ];
    
    public function up()
    {
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);            
        }
    }
    
    public function down()
    {
        foreach ($this->permissions as $permission) {
            Permission::delete(['name' => $permission]);            
        }
    }
}
```
## Defining Roles

As mentioned, you shouldn't "marry" your code with roles as they are considered as volatile entities
in the application more of a userland data, therefore:

- they are not required for your application to work;
- you should not "hardcode" them by their names in `@role()` or `hasRole()` calls;
- they can be added either to migrations or to seeders.

### AppShell's Default Admin Role

AppShell comes with one default role called `admin` that has access to all of the default appshell
permissions. This role is there to simplify the initial steps, but is not mandatory and can be
deleted.

If you keep this role, you may want to assign new permissions to it during migrations.

```php
class CreateVehiclePermissions extends Migration
{
    private $permissions = [
        'list vehicles',
        'create vehicles',
        'view vehicles',
        'edit vehicles',
        'delete vehicles',        
    ];
    
    public function up()
    {
        $createdPermissions = [];
        foreach ($this->permissions as $permission) {
            $createdPermissions[] = Permission::create(['name' => $permission]);            
        }
        
        $adminRole = Role::where(['name' => 'admin'])->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($createdPermissions);
        }
    }
    
    public function down()
    {
        $adminRole = Role::where(['name' => 'admin'])->first();
        
        foreach ($this->permissions as $permission) {
            if ($adminRole) {
                $adminRole->revokePermissionTo($permission);
            }
            Permission::delete(['name' => $permission]);            
        }
    }
}
``` 

## ACL Middleware

AppShell introduces the `acl` middleware that simplifies and standardizes the protection of
resources according to
[Laravel Resource naming conventions](https://laravel.com/docs/8.x/controllers#resource-controllers).

The ACL middleware, when applied to a route matches the Controller/Action name to a permission
and allows or denies (`abort(403)`) access to the route.

### Naming Convention

| Resource    | Capability                           | Controller            | Controller Action | Permission           |
|:------------|:-------------------------------------|:----------------------|:------------------|:---------------------|
| Product     | Seeing the list of products          | ProductController     | index             | list products        |
| Product     | Opening the create product page      | ProductController     | create            | create products      |
| Product     | Saving a new product                 | ProductController     | store             | create products      |
| Product     | Viewing a product                    | ProductController     | show              | view products        |
| Product     | Opening the edit product page        | ProductController     | edit              | edit products        |
| Product     | Saving an existing product           | ProductController     | update            | edit products        |
| Product     | Deleting a product                   | ProductController     | destroy           | delete products      |
| -           | -                                    | -                     | -                 | -                    |
| ProductType | Seeing the list of product types     | ProductTypeController | index             | list product types   |
| ProductType | Opening the create product type page | ProductTypeController | create            | create product types |
| ProductType | Saving a new product type            | ProductTypeController | store             | create product types |
| ProductType | Viewing a product type               | ProductTypeController | show              | view product types   |
| ProductType | Opening the edit product type page   | ProductTypeController | edit              | edit product types   |
| ProductType | Saving an existing product type      | ProductTypeController | update            | edit product types   |
| ProductType | Deleting a product type              | ProductTypeController | destroy           | delete product types |

As an example, the ACL middleware when applied to these routes will proceed like this:

```
URL /product/123/edit
 │
 └> Controller/Action = `ProductController@show`
    │
    └> Resource = Product, Action = show
       │
       └> Required permission = "view products"
          │
        ┌─┴─────────────────────────┐
        │$user->can('view products')│
        └─┬─────────────────────────┘
          │ ┌───┐
          ├─┤YES├─> Passed, continue
     ┌──┐ │ └───┘
403<─┤NO├─┘
     └──┘        
```

```
URL /product-types/123/edit
 │
 └> Controller/Action = `ProductTypeController@show`
    │
    └> Resource = ProductType, Action = show
       │
       └> Required permission = "view product types"
          │
        ┌─┴──────────────────────────────┐
        │$user->can('view product types')│
        └─┬──────────────────────────────┘
          │ ┌───┐
          ├─┤YES├─> Passed, continue
     ┌──┐ │ └───┘
403<─┤NO├─┘
     └──┘        
```

### ACL Resource Name Matching

It's important to understand that the ACL middleware is matching the controller and the action name,
and not the route definition, ie:

- `ProductTypeController` -> the resource name will be `ProductType` regardless of how the route is defined;
- `ProductTypeController::index` -> the action name will be `index` regardless of the route definition.

## Creating CRUD with ACL

The intended way to set up resourceful CRUDs is the following:

### Route Definition

Use Laravel's `Route::resource()` helper:

```php
// resources/routes/acl.php

Route::resource('product', 'ProductController');
//In case of multi-word resources:
Route::resource('product-type', 'ProductTypeController')
    ->parameters(['product-type' => 'productType']);// <- let the route param/variable to be properly named, ie `$productType` instead of `$product_type`
```

Add the route to module:

```php
// resources/config/module.php (or box.php)
return [
    // ...
    'routes' => [
        [
            'prefix'     => 'admin', // use arbitrary URL prefix
            'as'         => 'app.', // user arbitrary route name prefix
            'middleware' => ['web', 'auth', 'acl'], // Add the acl middleware
            'files'      => ['acl']
        ]
        //...
    ]
    //...
];
```

### Controller

```php
class ProductTypeController
{
    public function index() {/*...*/}
    
    public function show(ProductType $productType) {/*...*/}
    
    public function edit(EditProduct $request, ProductType $productType) {/*...*/}
    
    // ...
}
```

### Checking Permissions

In Blade Templates:

```blade
@can('create product types')
<a href="{{ route('app.product-types.create') }}">{{ __('Create Product') }}</a>
@endcan
```

In Menus:

```php
if ($menu = Menu::get('appshell')) {
    $settings = $menu->getItem('settings_group');
    $settings->addSubItem('product_types', __('Product Types'),
        ['route' => 'app.product-type.index'])
         ->allowIfUserCan('list product types'); // only show for users having the permission
}
```

## Non-standard Action Verbs

In certain cases you may want to add further actions and protect them by ACL.

In such cases enable the `allow_action_as_verb` configuration:

```php
// config/concord.php
return [
    'modules' => [
        Konekt\AppShell\Providers\ModuleServiceProvider::class => [
            // ...
            'acl' => [
                'allow_action_as_verb' => true
            ],
            // ...
```

Create the routes:

```php
Route::get('/reviews/{review}/reply');
Route::post('/reviews/{review}/reply');
```

Create the controller actions:

```php
class ReviewController
{
    public function reply(Request $request, Review $review)
    {
        if ($request->isMethod('post')) {
            // store the reply
            return redirect(/*...*/);
        }
        
        return view('review::review.reply');
    }
    //...
}
```

Create the permission (in a migration):

```php
class CreateReplyToReviewPermission extends Migration
{
    public function up()
    {
        Permission::create([
            'name' => 'reply reviews'
        ]);
        
    }
}
```

### Custom Action Verb Normalization

Custom action verbs are also transformed to comply with the AppShell permission naming style.

Examples:

| Resource | Action              | Permission                     |
|:---------|:--------------------|:-------------------------------|
| Review   | replyTo             | reply to reviews               |
| Absence  | requestApprovalFor  | request approval for absences  |
| Article  | rejectPublicationOf | reject publication of articles |

---

**Next**: [Menu Component &raquo;](menu.md)
