# Architecture

What the package is for, how its few pieces fit together, and where it falls short today.

## Why use this package

1. To automate generation of a permanent Zoho API `refresh_token`.
2. To provide a way of generating a Zoho API `access_token`, which normally expires after a set period.
3. To offer a gateway to interacting with the Zoho API.

## How it fits together

| Piece | Class | Role |
| --- | --- | --- |
| Provider | `Providers\ZohoOAuthServiceProvider` | Registers config, translations and the three commands through `laranail/package-tools`, and binds the two services with their config. |
| Credential base | `Services\ZohoCredentials` | Abstract. Builds request bodies, posts to `{base_oauth_url}/oauth/v2/token`, maps Zoho error codes to messages, and saves rows. |
| Init service | `Services\ZohoOAuthInit` | Exchanges the grant code (`grant_type=authorization_code`) for both tokens. |
| Refresh service | `Services\ZohoOAuthRefresh` | Exchanges the latest stored refresh token (`grant_type=refresh_token`) for a new access token. |
| Model | `Models\ZohoOauth` | One row per token issue, in the `zoho_oauth` table. |
| Commands | `Console\ZohoOAuthInitCommand`, `…RefreshCommand`, `…PruneCommand` | `laranail::crm-tools-zoho-oauth.init`, `laranail::crm-tools-zoho-oauth.refresh`, `laranail::crm-tools-zoho-oauth.prune`. |
| Facade | `Facades\ZohoOAuthFacade` | Resolves `laranail-crm-tools-zoho-oauth`, bound to an empty `ZohoOAuth` class. It exposes no methods yet. |

All classes sit under `Simtabi\Laranail\CrmTools\ZohoOAuth\`.

Tokens are append-only: every init or refresh inserts a row, and "the current token" is always `ZohoOauth::latest()->first()`. Pruning trims history rather than updating in place.

## Public names

Config (`laranail.crm-tools-zoho-oauth`), translations (`laranail/crm-tools-zoho-oauth::`), publish tags (`laranail::crm-tools-zoho-oauth-*`), the container binding (`laranail-crm-tools-zoho-oauth`) and the Artisan commands (`laranail::crm-tools-zoho-oauth.<command>`) carry the vendor and slug. The commands were `zoauth:*` until 0.1; those names are deprecated aliases that print one line naming the replacement and then run the command, until the next minor after 0.1. The commands extend `laranail/package-tools`' base `Command`, whose `WarnsOnDeprecatedAliases` prints that line for any alias outside the vendor scope.

## Known gaps

- **No revoke.** There is no method to revoke a refresh token.
- **`ZOHO_SCOPE` is not read.** Scopes are chosen in the Zoho console.

---

[← Docs index](../README.md#documentation)
