# Release

How the package is versioned and tested before a release.

## Versioning

The package is pre-1.0 and follows the laranail family convention: one moving `v0.1.0` tag, required as `^0.1`, with a `dev-main` → `0.1.x-dev` branch alias in `composer.json`. Because the tag moves, run `composer clear-cache` before `composer update` to be sure you receive the latest archive.

There is no release workflow in `.github/workflows/` yet; CI is `run-tests.yml`, which runs on pull requests against PHP 8.4 and 8.5 at lowest and stable dependency resolution. Changes are recorded in [CHANGELOG.md](../CHANGELOG.md).

## Testing

```bash
composer test
```

Formatting is checked with `composer lint` and fixed with `composer format`.

## Credits

- [Imani Manyara](https://github.com/imanimanyara)
- [All contributors](https://github.com/laranail/crm-tools-zoho-oauth/graphs/contributors)

---

[← Docs index](../README.md#documentation)
