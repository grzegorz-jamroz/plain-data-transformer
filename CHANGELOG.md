# Changelog
## [v1.1.0] - 2025.10.22
### Add
- Add unit tests for [Transform](src/Transform.php)
- Add docker support for development environment
- add PHPStan and PHP CS Fixer

### Change
- Change PHP version requirement to `>=8.4`

## [v1.0.0] - 2023.11.26
### Add
- [TransformNumeric](src/TransformNumeric.php)
  - add method `toInt`
  - add method `toFloat`
- Add unit tests for [TransformNumeric](src/TransformNumeric.php)

### Change
- [Transform](src/Transform.php)
  - changed cached type from \Exception to \Throwable

[v1.0.0]: https://github.com/grzegorz-jamroz/sf-api-bundle/releases/tag/v1.0.0]
