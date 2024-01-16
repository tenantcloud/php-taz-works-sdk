# [1.0.0-alpha.5](https://github.com/tenantcloud/php-taz-works-sdk/compare/v1.0.0-alpha.4...v1.0.0-alpha.5) (2024-01-16)


### Bug Fixes

* Date parsing for invalid dates ([#3](https://github.com/tenantcloud/php-taz-works-sdk/issues/3)) ([bc65d37](https://github.com/tenantcloud/php-taz-works-sdk/commit/bc65d37015a671af6afc57575c5d5bd3a615c583))

# [1.0.0-alpha.4](https://github.com/tenantcloud/php-taz-works-sdk/compare/v1.0.0-alpha.3...v1.0.0-alpha.4) (2024-01-15)


### Bug Fixes

* Deserialization of partial dates ([#2](https://github.com/tenantcloud/php-taz-works-sdk/issues/2)) ([e3a59f9](https://github.com/tenantcloud/php-taz-works-sdk/commit/e3a59f90a90e78f8c13d0e462aab0ed2eac62fc9))

# [1.0.0-alpha.3](https://github.com/tenantcloud/php-taz-works-sdk/compare/v1.0.0-alpha.2...v1.0.0-alpha.3) (2023-12-06)


### Bug Fixes

* Broken webhooks ([778b9bf](https://github.com/tenantcloud/php-taz-works-sdk/commit/778b9bfc188ec78cac53a04a0375d97134a0ed38))

# [1.0.0-alpha.2](https://github.com/tenantcloud/php-taz-works-sdk/compare/v1.0.0-alpha.1...v1.0.0-alpha.2) (2023-11-03)


### Bug Fixes

* PHPStan issue ([3f0173e](https://github.com/tenantcloud/php-taz-works-sdk/commit/3f0173e6765cfada4078b1fe2c4f6dd1e21aa234))
* Use alpha version of serialization ([6e29561](https://github.com/tenantcloud/php-taz-works-sdk/commit/6e2956141745ce5f65555bb3e0548641a1035482))

# 1.0.0-alpha.1 (2023-11-02)


### Bug Fixes

* Add missing order in ->results ([d67c97a](https://github.com/tenantcloud/php-taz-works-sdk/commit/d67c97ab6899eb602438fde128e0ac141a685e9d))
* Broken event imitation ([a28d536](https://github.com/tenantcloud/php-taz-works-sdk/commit/a28d5369b327e324de1ae73d9a1bb9cb357d8224))
* Dispatching job in sync queue with delay with our custom implementation ([72191cd](https://github.com/tenantcloud/php-taz-works-sdk/commit/72191cd4469ff446aa897d7544baf66cfec6722f))
* Failing tests ([cd865a4](https://github.com/tenantcloud/php-taz-works-sdk/commit/cd865a4e14633d6632856f1b92363bfcfe5dc262))
* Fake order searches status ([61642ba](https://github.com/tenantcloud/php-taz-works-sdk/commit/61642ba60d3f8c4595d252034c83850e659e3fab))
* Include applicant middleName in the DTO ([ef02a10](https://github.com/tenantcloud/php-taz-works-sdk/commit/ef02a10407843608f6725606a09ed884055152d4))
* Make UpsertApplicantDTO constructor public ([3a27558](https://github.com/tenantcloud/php-taz-works-sdk/commit/3a275589e1dc359c4bdd8cfaba727042b4ff9940))
* Missing laravel auto discovery ([194fc8c](https://github.com/tenantcloud/php-taz-works-sdk/commit/194fc8c3ca3adb865e6dc70c9b49935220604e5c))
* Only imitate events if TazWorks thinks they're complete ([c7071c5](https://github.com/tenantcloud/php-taz-works-sdk/commit/c7071c546ad9db1198c7254894d9a7d0051eb617))
* PHPStan ([c5b8553](https://github.com/tenantcloud/php-taz-works-sdk/commit/c5b8553a578c93df5b4383bc9428c8d39b40c250))


### Features

* Add new fields for NationalCriminalResult ([5255f35](https://github.com/tenantcloud/php-taz-works-sdk/commit/5255f35e574835240924b0da20bf1f9a2e1450a0))
* Add order search status and safe fallbacks for unknown enum cases just in case ([040c82b](https://github.com/tenantcloud/php-taz-works-sdk/commit/040c82b9c08726338318c1fc1f5f99918e105733))
* Addresses API, applicant/product ID in the order itself ([3d2321f](https://github.com/tenantcloud/php-taz-works-sdk/commit/3d2321f33d918cc014fe7a3a0fd974b11385ee3d))
* Fake client for testing ([d4c5777](https://github.com/tenantcloud/php-taz-works-sdk/commit/d4c57777ea26fb0358900fe13912836f68fb5006))
* Order search completed event ([b3291ca](https://github.com/tenantcloud/php-taz-works-sdk/commit/b3291ca4a542c77d803b14604a421146ba3bc56e))
* Updating applicants ([6c77f33](https://github.com/tenantcloud/php-taz-works-sdk/commit/6c77f33b190fb48a01ee764f1218f9c082a1c707))
