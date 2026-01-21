# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Build and Test Commands

```bash
make test                    # Run unit tests (excludes integration tests)
make test-integration        # Run integration tests (requires credentials)
make examples                # Run all example scripts
make us_street_api           # Run US Street API examples
```

To run a single test file:
```bash
phpunit tests/US_Street/ClientTest.php
```

To run a specific test method:
```bash
phpunit --filter testMethodName tests/US_Street/ClientTest.php
```

## Architecture Overview

This is the official SmartyStreets PHP SDK for address validation APIs. All code lives under the `SmartyStreets\PhpSdk` namespace with PSR-4 autoloading.

### Core Components

**ClientBuilder** (`src/ClientBuilder.php`) - Entry point for creating API clients. Uses fluent builder pattern with chainable methods (`retryAtMost()`, `withMaxTimeout()`, `withLicenses()`). Each API has a dedicated build method (e.g., `buildUsStreetApiClient()`).

**Sender Chain** - HTTP requests flow through a decorator/chain pattern:
```
CustomQuerySender → LicenseSender → URLPrefixSender → SigningSender → RetrySender → StatusCodeSender → NativeSender (cURL)
```
Each sender wraps the next and implements the `Sender` interface.

**API Modules** - Each API (US_Street, US_ZIPCode, International_Street, etc.) has its own directory with:
- `Client.php` - API client with `sendLookup()` and `sendBatch()` methods
- `Lookup.php` - Input container implementing `JsonSerializable`
- `Candidate.php` - Response object
- Supporting classes for metadata, components, analysis results

### Key Patterns

- **Batch Processing**: `Batch` class holds up to 100 lookups per request. Results map back to inputs by index.
- **Authentication**: `Credentials` interface with `StaticCredentials` and `SharedCredentials` implementations.
- **Exception Hierarchy**: All exceptions inherit from `SmartyException`. Status codes map to specific exceptions (e.g., `BadCredentialsException`, `TooManyRequestsException`).
- **Retry Logic**: `RetrySender` handles retryable status codes (408, 429, 500, 502, 503, 504) with backoff via `Sleeper` interface.

### Testing Structure

Tests mirror the src directory structure. Key test utilities in `tests/Mocks/`:
- `MockSender` - Mocks HTTP responses
- `RequestCapturingSender` - Captures requests for assertions
- `MockSerializer`, `MockSleeper`, `MockLogger` - Infrastructure mocks

### Dependencies

- PHP >= 5.6
- Zero runtime dependencies (PSR Log is optional for custom logging)
- Dev: PHPUnit 9
