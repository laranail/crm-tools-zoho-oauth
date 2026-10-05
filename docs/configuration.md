# Configuration

Four keys, all under `laranail.crm-tools-zoho-oauth`, each set from one environment variable.

## Keys

| Key | Variable | Default | Meaning |
| --- | --- | --- | --- |
| `base_oauth_url` | `BASE_OAUTH_URL` | `https://accounts.zoho.com` | Accounts server for your data centre. The token endpoint is this plus `/oauth/v2/token`, so omit the trailing slash. |
| `client_id` | `ZOHO_CLIENT_ID` | none | Public identifier of your Zoho self client. |
| `client_secret` | `ZOHO_CLIENT_SECRET` | none | Secret issued with the client ID, known only to your application and Zoho. |
| `code` | `ZOHO_CODE` | none | Grant token from the Zoho API console. It is exchanged by `laranail::crm-tools-zoho-oauth.init` and expires shortly after it is generated. |

Read them with `config('laranail.crm-tools-zoho-oauth.client_id')` and so on. The bare `config('crm-tools-zoho-oauth.*')` key is not registered and returns `null`.

## Publishing

```bash
php artisan vendor:publish --tag=laranail::crm-tools-zoho-oauth-config
```

This writes the file to `config/laranail/crm-tools-zoho-oauth.php`.

## Not configuration

`ZOHO_SCOPE` is not read anywhere in the package. Scopes are fixed when you generate the grant code in the Zoho console; see [Create Zoho OAuth credentials](recipes/create-zoho-oauth-credentials.md).

---

[← Docs index](../README.md#documentation)
