# Disqus Changelog

## 4.0.1 - 2024.10.06
### Added
* Added a **Lazy Load Disqus** settings option, so you can control whether the Disqus JavaScript is lazily loaded or not ([#8](https://github.com/nystudio107/craft-disqus/issues/8))
* Added the ability to pass in additional attributes that will be added to the rendered Disqus `<script>` tag ([#28](https://github.com/nystudio107/craft-disqus/issues/28))
* Added the ability to use environment variables / aliases for the additional settings ([#15](https://github.com/nystudio107/craft-disqus/pull/15/))
* Add `phpstan` and `ecs` code linting
* Add `code-analysis.yaml` GitHub action

### Fixed
* Fixed an issue where avatars wouldn't display ([#37](https://github.com/nystudio107/craft-disqus/issues/37))
* Fixed an issue where incorrect headers were sent if the API key was an environment variable or alias ([#15](https://github.com/nystudio107/craft-disqus/pull/15/))

## 4.0.0 - 2022.06.01
### Added
* Initial Craft CMS 4 release

## 4.0.0-beta.3 - 2022.04.11
### Fixed
* Fixed an issue where the Disqus tag was not output as HTML, but rather a plain text via the Twig Extension

## 4.0.0-beta.2 - 2022.04.11
### Fixed
* Fixed an issue where the Disqus tag was not output as HTML, but rather a plain text

## 4.0.0-beta.1 - 2022.03.25
### Added
* Initial Craft CMS 4 compatibility
