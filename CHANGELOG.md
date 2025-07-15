# Changelog

See the changelog repository:

github.com/smartystreets/changelog/blob/master/sdk/php.md

## [MAJOR] Migrated to PSR-7/17/18 HTTP Abstractions
- All HTTP operations now use PSR-7, PSR-17, and PSR-18 interfaces.
- Legacy classes Sender, Request, Response, NativeSender, and related are deprecated.
- All client classes now require a PSR-18 client and PSR-17 factories.
- See README for new usage patterns and migration guidance.