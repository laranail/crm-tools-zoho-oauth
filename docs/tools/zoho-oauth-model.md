# The `ZohoOauth` model

`ZohoOauth` (`Simtabi\Laranail\CrmTools\ZohoOAuth\Models\ZohoOauth`) is one issued token, stored in the `zoho_oauth` table.

## Columns

| Column | Type | Notes |
| --- | --- | --- |
| `id` | big integer | Primary key. |
| `refresh_token` | string | Indexed. Carried forward unchanged by every refresh. |
| `access_token` | string | Unique. |
| `expires_at` | timestamp | Cast to a `datetime`. |
| `token_type` | string, nullable | As returned by Zoho. |
| `api_domain` | string, nullable | The API host Zoho returned for your data centre. |
| `created_at`, `updated_at` | timestamps | `latest()` orders by `created_at`. |

All attributes are mass-assignable (`$guarded = []`).

## Appended attributes

| Attribute | Value |
| --- | --- |
| `auth_token` | `"Zoho-oauthtoken {access_token}"`, ready for the `Authorization` header. |
| `is_expired` | `true` once `expires_at` is in the past. |

```php
$row = ZohoOauth::latest()->first();

if ($row && ! $row->is_expired) {
    Http::withHeaders(['Authorization' => $row->auth_token])->get($url);
}
```

## Factory

`ZohoOauth::factory()` returns `Simtabi\Laranail\CrmTools\ZohoOAuth\Database\Factories\ZohoOAuthFactory`: the model names it in `newFactory()`, since the class names differ and Laravel's convention would not find it.

---

[← Docs index](../../README.md#documentation)
