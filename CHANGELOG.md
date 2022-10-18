# Units Changelog

## 4.0.1 - UNRELEASED
### Fixed
* Fixed an issue that through a Typed Property Error exception when creating a Units field ([#41](https://github.com/nystudio107/craft-units/issues/41))

## 4.0.0 - 2022.05.17
### Added
* Initial Craft CMS 4 release

### Fixed
* Fixed an issue that would cause the field type to be unusable if you were running PHP 8 or later, due to additions in the token parser in PHP 8 ([#40](https://github.com/nystudio107/craft-units/issues/40))

## 4.0.0-beta.1 - 2022.03.17

### Added

* Initial Craft CMS 4 compatibility

## 1.0.4 - 2020-10-27
### Fixed
- Fixed Composer 2 compatibility

## 1.0.3 - 2018-05-16
### Changed
- Handle incoming numeric values from a converted Number field type

## 1.0.2 - 2018-05-14
### Changed
- Handle cases where there is no `min` or `max` properly in the validator

## 1.0.1 - 2018-05-14
### Changed
- Added null checks in the Field's `init()` method

## 1.0.0 - 2018-05-12
### Added
- Initial release
