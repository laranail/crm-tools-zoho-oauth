# Commands

Three Artisan commands, registered when the application runs in the console.

> Until 0.1 these were `zoauth:init`, `zoauth:refresh` and `zoauth:prune`. Those names still work,
> including in a schedule, as deprecated aliases: each prints one `Deprecated:` line naming the
> replacement and then runs the command. They are removed no earlier than the next minor after 0.1;
> update `Schedule::command()` calls to the names below.

## `laranail::crm-tools-zoho-oauth.init`

Initialize Zoho OAuth `refresh_token` and `access_token`. Class `Simtabi\Laranail\CrmTools\ZohoOAuth\Console\ZohoOAuthInitCommand`, which calls `Services\ZohoOAuthInit::initializeTokens()`.

Posts `client_id`, `client_secret`, `code` and `grant_type=authorization_code` to `{base_oauth_url}/oauth/v2/token` and stores the returned tokens as a new row. If Zoho answers with an `error`, the mapped message is printed and nothing is stored. A non-2xx HTTP response throws a `RuntimeException`.

## `laranail::crm-tools-zoho-oauth.refresh`

Generate a new access token from the refresh token. Class `Console\ZohoOAuthRefreshCommand`, which calls `Services\ZohoOAuthRefresh::generateNewRefreshToken()`.

Requires at least one stored row; with an empty table it prints a "run `laranail::crm-tools-zoho-oauth.init` first" message and makes no request. Otherwise it posts the latest `refresh_token` with `grant_type=refresh_token` and stores a new row that carries the new `access_token` and the same `refresh_token`.

## `laranail::crm-tools-zoho-oauth.prune`

Delete all except the 10 most recent tokens. Class `Console\ZohoOAuthPruneCommand`; the count is the `TOKENS_TO_RETAIN` constant. With an empty table it warns and exits.

## Exit codes

All three return `0`, including when Zoho reports an error in its response body; only an exception, such as the `RuntimeException` on a non-2xx response, ends a run with a failure code. Read the printed message rather than the exit code to tell success from failure.

---

[← Docs index](../../README.md#documentation)
