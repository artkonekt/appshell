# Add Assets To The Layout

There are two Blade files that you can use to inject additional assets into the AppShell layout:

- `_footer_includes`, and
- `_header_includes`.

You can use these partials to add extra scripts, styles for your application.
The contents of these file will be injected in the layout:

- in the html head section, after AppShell stylesheets (`_header_includes`)
- before the closing body tag (`_footer_includes`). 

To populate the content of these view files in your application, create the following file(s):

- resources/views/vendor/appshell/layouts/default/_header_includes.blade.php
- resources/views/vendor/appshell/layouts/default/_footer_includes.blade.php

**Example:**

Inject the DataDog RUM script only in production and only for logged in users.

Content of `resources/views/vendor/appshell/layouts/default/_footer_includes.blade.php`:

```blade
@production
    @auth()
        <script
                src="https://www.datadoghq-browser-agent.com/datadog-rum.js"
                type="text/javascript">
        </script>
        <script>
            window.DD_RUM && window.DD_RUM.init({
                applicationId: 'eeeeeeee-ffff-4444-bbbb-333333333333',
                clientToken: 'pub33333333333333333333333333333333'
            });
        </script>
    @endauth
@endproduction
```
