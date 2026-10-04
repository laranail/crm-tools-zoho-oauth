# Changelog

All notable changes to `laravel-zoho-oauth` will be documented in this file

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Changed

- The README follows the org documentation standard. Its content moved into `docs/` (installation,
  getting started, configuration, architecture, release, command and model reference, two recipes),
  with stale Laravel 9 scheduling and the unused `ZOHO_SCOPE` setting corrected.

### Fixed

- **The migration is publishable.** The provider called `hasMigrations()` with no file names, so
  the `zoho_oauth` table's migration was neither loaded nor published. It is now registered and
  publishes under `laranail::crm-tools-zoho-oauth-migrations`.
- **Messages print.** The services and the prune command asked for `zoho-oauth::zoauth.*` while the
  translations are registered under `laranail/crm-tools-zoho-oauth`, so every command printed its
  raw key. They use the registered namespace; a test resolves every key the source uses.
- **`ZohoOauth::factory()` works.** The model names its factory, whose class name Laravel's
  convention could not guess.
- **`zoauth:init` and `zoauth:refresh` run.** The provider bound `ZohoOAuthInit` and
  `ZohoOAuthRefresh` under `Simtabi\Laranail\CrmTools\ZohoOAuth\`, where no such classes exist,
  while the commands resolve the real ones under `...\ZohoOAuth\Services\`. Those were never
  bound, so the container tried to autowire four `string` parameters and both commands threw a
  `BindingResolutionException`. The bindings now name the real classes.

### Removed

- **The legacy `docs/index.md` and `docs/instructions.md` pages.** Their content had already
  moved: prerequisites, install, environment and config to `installation.md`; init, refresh,
  scheduling and token use to `getting-started.md` and `recipes/schedule-token-maintenance.md`;
  credential setup (with all eight `images/Step-0N.png`) to
  `recipes/create-zoho-oauth-credentials.md`. They were also wrong where they differed: they showed
  a `revoke()` method that does not exist, spelled the table `zoho_outh`, and linked a pre-rename
  Jekyll path. `docs/images/` stays, since the recipe uses it.

## 1.0.0 - 2023-30-03

- initial release

[Unreleased]: https://github.com/laranail/crm-tools-zoho-oauth/compare/v0.1.0...HEAD
