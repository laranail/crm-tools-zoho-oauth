# Changelog

All notable changes to `laravel-zoho-oauth` will be documented in this file

## Unreleased

### Fixed

- **`zoauth:init` and `zoauth:refresh` run.** The provider bound `ZohoOAuthInit` and
  `ZohoOAuthRefresh` under `Simtabi\Laranail\CrmTools\ZohoOAuth\`, where no such classes exist,
  while the commands resolve the real ones under `...\ZohoOAuth\Services\`. Those were never
  bound, so the container tried to autowire four `string` parameters and both commands threw a
  `BindingResolutionException`. The bindings now name the real classes.

## 1.0.0 - 2023-30-03

- initial release
