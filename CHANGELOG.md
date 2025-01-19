# Units Changelog

## 4.0.2 - UNRELEASED
### Added
* Add `ecs` and `phpstan` code quality tools

## 4.0.1 - 2023.04.24
### Changed
* Updated the docs to use VitePress `^1.0.0-alpha.29`
* Allow for versioning of the docs

### Fixed
* Fixed an issue that through a Typed Property Error exception when creating a Units field ([#41](https://github.com/nystudio107/craft-units/issues/41))
* Add `allow-plugins` to `composer.json` to fix CI

## 4.0.0 - 2022.05.17
### Added
* Initial Craft CMS 4 release

### Fixed
* Fixed an issue that would cause the field type to be unusable if you were running PHP 8 or later, due to additions in the token parser in PHP 8 ([#40](https://github.com/nystudio107/craft-units/issues/40))

## 4.0.0-beta.1 - 2022.03.17

### Added

* Initial Craft CMS 4 compatibility
