# CHANGELOG

## 0.3.1

### Documentation
- Added changelog

## 0.3.0

### Gutenberg blocks
- Refresh theme with initial Gutenberg blocks
- These changes sync the base theme (and only the base theme) to match what has been set up within the https://github.com/Taoti/wordpress-ci-repeat repository

## 0.2.3

### Includes
- Fixing file-includes for `functions.php`

## 0.2.2

### Background
- Trying to run `npm install` or `lando npm install` fails with current build-set:

```
npm ERR! code ELIFECYCLE
npm ERR! errno 1
npm ERR! gifsicle@5.0.0 postinstall: `node lib/install.js`
npm ERR! Exit status 1
npm ERR! 
npm ERR! Failed at the gifsicle@5.0.0 postinstall script.
npm ERR! This is probably not a problem with npm. There is likely additional logging output above.

npm ERR! A complete log of this run can be found in:
npm ERR!     /var/www/.npm/_logs/2021-10-26T14_39_07_493Z-debug.log
```

### Hotfix
- Though only a temporary fix (its still `npm` version `12.x`!), grabbing the working (updated) code from `humentum-wp` works fine.

## 0.2.1

### Theme PHP Requirements
- Added PHP version to `composer.json`

## 0.2.0

### Composer Setup
- I added a handful of `@todo` items, where changes were needed. There are also a handful where it looks like unused-but-optional code needs to just be shifted into either Lepton or the Readme file.
- The TinyMCE -> Light needs testing, as I have to completely rewrite the way the PHP was written. Should be no functional changes.
- Replaced `@since 1.0.0` in a number of places with `@since 0.1.1`, as the Composer plugin is configured to start at `0.1.0`.
- There are a handful of accessibility red flags that I noticed. The `pagination.php` one I flagged, but the others I just sorta 'fixed on the way' when setting up the TWIG files so, uh, they are copied in those files. :p
- Added a `.nvmrc` file set to `use 14`. I think it is supposed to be `12` though.... :p

### Changes Still Needed (at a later date)
- Move a BUNCH of code into Lepton.
- Update `readme.md` with much better instruction.
- Move the `Modules` folder into the inc/ folder and correctly namespace it to `namespace TaotiBaseTheme\Modules` (PSR-4 autoloading preparation). (Maybe just namespace TaotiTheme...? I added baseTheme in case we convert into a 'parent theme' setup and taoti.com's subtheme goes for `TaotiTheme`..... )
- Update all of the inc/ files and convert them into classes with `namespace TaotiBaseTheme`. (PSR-4 autoloading preparation).

### Separate Tasks Needed
- Though not technically part of this repo, `use JP\Get` is still in place for the `Modules\Table`, so that plugin needs auditing before we can enable things for CircleCI. It should probably be converted into a Composer package as well, since we're going to have to keep it going forward at least until we can backport the functionality into the base theme and/or a separate plugin.
- Create `taoti-prevent-acf-field-sync/` as a Composer plugin with `type -> 'wordpress-muplugin/`.

## 0.1.0

### Init
- Initial version
