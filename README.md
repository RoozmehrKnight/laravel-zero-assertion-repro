# Laravel `assertSeeText('0')` regression PoC

This minimal Laravel application returns exactly `hello` from `/`. Its single feature test expects the public `$response->assertSeeText('0')` API to throw `PHPUnit\Framework\AssertionFailedError`, because the response does not contain `0`.

## Reproduce

Requires PHP 8.3 or newer and Composer. No database, frontend build, or environment file is needed.

```sh
git switch laravel-12   # or: git switch laravel-13
composer install
composer test
```

Switch branches, run `composer install` again to apply that branch's lockfile, then run `composer test` again. The test and application files are identical on both branches.

## Results

Tested with PHP 8.3.22 and PHPUnit 11.5.57:

| Branch | Locked Laravel version | Actual `composer test` result |
| --- | --- | --- |
| `laravel-12` | 12.69.3 | **Pass** (`OK`, exit code 0): the missing `0` raises the expected assertion failure. |
| `laravel-13` | 13.35.0 | **Fail** (exit code 1): `Failed asserting that exception of type "PHPUnit\Framework\AssertionFailedError" is thrown.` |

Laravel 12 checks that each requested text value occurs in the response. Laravel 13 routes this assertion through `SeeInHtml`, where `empty($value)` skips the string `'0'`. The same test therefore catches the missing value on Laravel 12 but silently accepts it on Laravel 13. Both branches use unmodified Composer releases of Laravel.

Context: [PR #61839](https://github.com/laravel/framework/pull/61839) and [PR #61920](https://github.com/laravel/framework/pull/61920).
