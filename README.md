# laranail/crm-tools-zoho-oauth

[![Tests](https://github.com/laranail/crm-tools-zoho-oauth/actions/workflows/run-tests.yml/badge.svg)](https://github.com/laranail/crm-tools-zoho-oauth/actions/workflows/run-tests.yml)
[![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

Two badges, not four: the package is not on Packagist, so there is no registry version to show, and the repository has no static-analysis workflow yet.

> Generate, refresh and store Zoho OAuth access and refresh tokens in a Laravel application.

Requires PHP `^8.4.1 || ^8.5` on Laravel `^13.0` (`illuminate/support`).

## Install

The package resolves through a VCS repository, not Packagist. Add the repositories to your application's `composer.json`, then require it:

```json
"repositories": [
    { "type": "vcs", "url": "https://github.com/laranail/crm-tools-zoho-oauth" },
    { "type": "vcs", "url": "https://github.com/laranail/package-tools" }
]
```

```bash
composer require laranail/crm-tools-zoho-oauth:^0.1
```

Credentials, the database table and the config file are covered in [Installation](docs/installation.md).

## Quick start guide and usage

### Getting started

1. Add your Zoho credentials to `.env`, from the Zoho API console ([Create Zoho OAuth credentials](docs/recipes/create-zoho-oauth-credentials.md)):

   ```dotenv
   BASE_OAUTH_URL=https://accounts.zoho.com
   ZOHO_CLIENT_ID=
   ZOHO_CLIENT_SECRET=
   ZOHO_CODE=
   ```

2. Publish the migration for the `zoho_oauth` table, then run it:

   ```bash
   php artisan vendor:publish --tag=laranail::crm-tools-zoho-oauth-migrations
   php artisan migrate
   ```

3. Exchange the grant code for the first refresh and access token:

   ```bash
   php artisan laranail::crm-tools-zoho-oauth.init
   ```

### Usage

```php
use Illuminate\Support\Facades\Http;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Models\ZohoOauth;

// After `php artisan laranail::crm-tools-zoho-oauth.init` has stored the first refresh and access token.
$token = ZohoOauth::latest()->first()?->auth_token; // "Zoho-oauthtoken 1000.…"

$leads = Http::withHeaders(['Authorization' => $token])
    ->get('https://www.zohoapis.com/crm/v2/Leads')
    ->json('data');
```

Keep the access token fresh by scheduling a refresh in `routes/console.php`:

```php
use Illuminate\Support\Facades\Schedule;

Schedule::command('laranail::crm-tools-zoho-oauth.refresh')->everyThirtyMinutes();
```

The full walkthrough is in [Getting started](docs/getting-started.md); everything else is in the [documentation index](#documentation).

## <a name="documentation"></a>Documentation

Hosted at [opensource.simtabi.com/documentation/laranail/crm-tools-zoho-oauth](https://opensource.simtabi.com/documentation/laranail/crm-tools-zoho-oauth/).

### Guides

- [Installation](docs/installation.md) — requirements, Composer setup, environment variables and the `zoho_oauth` table.
- [Getting started](docs/getting-started.md) — store the first tokens, keep the access token fresh, and call a Zoho API.
- [Configuration](docs/configuration.md) — every key under `laranail.crm-tools-zoho-oauth` and the variable that sets it.
- [Architecture](docs/architecture.md) — why the package exists, how its pieces fit, and its known gaps.
- [Release](docs/release.md) — versioning, the test gate, and credits.

### Reference

- [Commands](docs/tools/commands.md) — `laranail::crm-tools-zoho-oauth.init`, `laranail::crm-tools-zoho-oauth.refresh` and `laranail::crm-tools-zoho-oauth.prune`.
- [The `ZohoOauth` model](docs/tools/zoho-oauth-model.md) — the stored token row and its `auth_token` and `is_expired` attributes.

### Recipes

- [Create Zoho OAuth credentials](docs/recipes/create-zoho-oauth-credentials.md) — get a client ID, client secret and grant code from the Zoho API console.
- [Schedule token maintenance](docs/recipes/schedule-token-maintenance.md) — refresh the access token and prune old rows on a schedule.

### Project

- [Changelog](CHANGELOG.md) — what has changed recently.
- [Contributing](CONTRIBUTING.md) — how to propose a change.

## Contributing & security

Contributions are welcome; see [CONTRIBUTING.md](CONTRIBUTING.md). Report vulnerabilities privately as described in [SECURITY.md](SECURITY.md), never in the issue tracker.

## License

MIT © Simtabi LLC. See [LICENSE](LICENSE).
