# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).


## [Unreleased]

### Changed:

- Update integration test to check environment variables to enable alternative API URLs (`SMARTY_URL_INTERNATIONAL`, `SMARTY_URL_US_AUTOCOMPLETE`, `SMARTY_URL_US_EXTRACT`, `SMARTY_URL_US_STREET`, `SMARTY_URL_US_ZIP`).

## [4.5.7] - 2019-01-15

### Changed:

- By default add `Accept-Encoding: gzip` header to request and handle gzipped response.

## [4.5.6] - 2018-09-18

### Changed:

- Standardized `Makefile`.
- Push latest commits to repo when running `make publish`.


## [Earlier]

For details on earlier changes, please see the [releases listing](https://github.com/smartystreets/smartystreets-php-sdk/releases).

------------

[Unreleased]: https://github.com/smartystreets/smartystreets-php-sdk/compare/4.5.6...HEAD
[4.5.6]: https://github.com/smartystreets/smartystreets-php-sdk/compare/4.5.5...4.5.6
[Earlier]: https://github.com/smartystreets/smartystreets-php-sdk/releases
