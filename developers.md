# Developing AppShell Itself

You find guides how to develop AppShell if you want to contribute to
AppShell itself.

## Testing

**To test against PHP 8.0**:

```bash
docker-compose run appshell_test_php80 sh -c 'cd build && vendor/bin/phpunit --stop-on-error'
```

**To test against PHP 8.1**:

```bash
docker-compose run appshell_test_php81 sh -c 'cd build && vendor/bin/phpunit --stop-on-error'
```
