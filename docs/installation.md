# Installation

Install the package, give it your Zoho credentials, and create the table the tokens are stored in.

## Requirements

- PHP `^8.4.1 || ^8.5`.
- Laravel `^13.0` (`illuminate/support`), plus `guzzlehttp/guzzle` `^7.8 || ^8.0`.
- A [Zoho](https://zoho.com/) account. If you do not have one, [create one now](https://accounts.zoho.com/register).
- Some familiarity with the Zoho API you intend to call. The most popular ones:

  | Zoho app | API documentation |
  | --- | --- |
  | Zoho Inventory | [API documentation](https://www.zoho.com/inventory/) |
  | Zoho CRM | [API documentation](https://www.zoho.com/crm/developer/docs/api/v2/modules-api.html) |
  | Zoho Campaigns | [API documentation](https://www.zoho.com/campaigns/help/developers/) |
  | Zoho Books | [API documentation](https://www.zoho.com/books/api/v3/) |
  | Zoho Projects | [API documentation](https://www.zoho.com/projects/help/rest-api/get-tickets-api.html/) |

- A Zoho API client ID, client secret and authorization (grant) code. If you do not have them, follow [Create Zoho OAuth credentials](recipes/create-zoho-oauth-credentials.md).

## Composer

The package is not on Packagist. It resolves through VCS repositories, and Composer ignores a dependency's own `repositories`, so your application must list this package **and** `laranail/package-tools`, which it requires:

```json
"repositories": [
    { "type": "vcs", "url": "https://github.com/laranail/crm-tools-zoho-oauth" },
    { "type": "vcs", "url": "https://github.com/laranail/package-tools" }
]
```

```bash
composer require laranail/crm-tools-zoho-oauth:^0.1
```

The service provider, `Simtabi\Laranail\CrmTools\ZohoOAuth\Providers\ZohoOAuthServiceProvider`, is auto-discovered.

## Environment variables

Add these to `.env` and fill them in from the Zoho API console:

```dotenv
# Zoho OAuth credentials
BASE_OAUTH_URL=https://accounts.zoho.com
ZOHO_CLIENT_ID=
ZOHO_CLIENT_SECRET=
ZOHO_CODE=
```

`BASE_OAUTH_URL` is the accounts server of the data centre your Zoho organisation lives in, and defaults to `https://accounts.zoho.com`:

| Data centre | `BASE_OAUTH_URL` |
| --- | --- |
| United States | `https://accounts.zoho.com` |
| Europe | `https://accounts.zoho.eu` |
| India | `https://accounts.zoho.in` |
| Australia | `https://accounts.zoho.com.au` |

Leave off the trailing slash: the package appends `/oauth/v2/token` itself, so `https://accounts.zoho.in/` produces a double slash in the token URL. See [Zoho's multi-DC notes](https://www.zoho.com/inventory/api/v1/#multidc).

> Earlier versions of these docs also listed `ZOHO_SCOPE`. Nothing in the package reads it: scopes are chosen in the Zoho console when the grant code is generated, not sent by the package. Do not set it expecting an effect.

## Database

Tokens are stored in a `zoho_oauth` table (`id`, `refresh_token`, `access_token`, `expires_at`, `token_type`, `api_domain`, timestamps). The migration ships as `database/migrations/create_zoho_oauth_table.php`.

Publish the migration, then run it:

```bash
php artisan vendor:publish --tag=laranail::crm-tools-zoho-oauth-migrations
php artisan migrate
```

## Config and translations

Publishing is optional; the packaged defaults read the environment variables above.

```bash
php artisan vendor:publish --tag=laranail::crm-tools-zoho-oauth-config
php artisan vendor:publish --tag=laranail::crm-tools-zoho-oauth-translations
```

The keys are described in [Configuration](configuration.md).

---

[← Docs index](../README.md#documentation)
