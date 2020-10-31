## Using Custom Models

AppShell imports several Models (entities) from underlying components like [Address](https://konekt.dev/address)
or [Customer](https://konekt.dev/customer).

To see the available models use the following command:

```bash
php artisan concord:models

+---------------+-------------------------------------------+----------------------------------------+
| Entity        | Contract                                  | Model                                  |
+---------------+-------------------------------------------+----------------------------------------+
| Address       | Konekt\Address\Contracts\Address          | Konekt\AppShell\Models\Address        |
| Customer      | Konekt\Customer\Contracts\Customer        | Konekt\Customer\Models\Customer       |
| Organization  | Konekt\Address\Contracts\Organization     | Konekt\Address\Models\Organization     |
| Permission    | Konekt\Acl\Contracts\Permission           | Konekt\Acl\Models\Permission           |
| Person        | Konekt\Address\Contracts\Person           | Konekt\Address\Models\Person           |
| Profile       | Konekt\User\Contracts\Profile             | Konekt\User\Models\Profile             |
| Province      | Konekt\Address\Contracts\Province         | Konekt\Address\Models\Province         |
| Role          | Konekt\Acl\Contracts\Role                 | Konekt\Acl\Models\Role                 |
| User          | Konekt\User\Contracts\User                | Konekt\AppShell\Models\User            |
+---------------+-------------------------------------------+----------------------------------------+
```

These models can be customized/replaced by your application.

See this complete reference about
[how to use custom models in your application](https://vanilo.io/how-to/use-custom-models-in-your-application)
on vanilo.io.

---

**✔ You've reached the end of this Documentation!**
