# Schedule token maintenance

Refresh the access token before it expires and prune old rows, from `routes/console.php`.

## Schedule both commands

The access token usually expires after one hour, so refresh more often than that. Every refresh adds a row, so prune daily:

```php
// routes/console.php
use Illuminate\Support\Facades\Schedule;

Schedule::command('laranail::crm-tools-zoho-oauth.refresh')->everyThirtyMinutes();
Schedule::command('laranail::crm-tools-zoho-oauth.prune')->daily();
```

The scheduler must be running (`php artisan schedule:work` locally, or the `schedule:run` cron entry in production). See [Commands](../tools/commands.md) for what each command does.

---

[← Docs index](../../README.md#documentation)
