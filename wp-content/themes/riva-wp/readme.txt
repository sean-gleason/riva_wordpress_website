Setting up a new project | How to use Gulp

Basic set up for a new project on your local machine.

1. Copy the jp-base theme and rename it based on the project/client name.

2. Open `<project-theme>/style.css` and update the information here based on the project/client. Now you can switch to this theme in the WordPress Dashboard.

3. Move any plugins you need from the `<project-theme>/_recommended-plugins/` folder into the main plugins folder `wp-content/plugins`. Remember to update the plugins on your local machine (either download manually or update from the WP Dashboard). Commit and push any updates.

4. Set up any post types you need in `<project-theme>/inc/post-types.php`.

5. Set up any taxonomies you need in `<project-theme>/inc/taxonomies.php`.

6. Add/remove, enable/disable any other customizations you need for the other stuff in the `<project-theme>/inc/` folder.

7. Add template files to the root theme folder, add parts to the `<project-theme>/parts/` folder, and add modules to the `<project-theme>/modules/` folder.

8. Custom JS can be added to `<project-theme>/js/development/after-libs/` or `before-libs/`. Add libraries in `libs/`. JS can also be included in the `js/` folder in each module. For any JS you only want to enqueue on the Dashboard, place those files in `<project-theme>/js/admin/`.

9. Non-critical CSS is all compiled into one file which gets lazy-loaded. Keep non-critical scss files in `<project-theme>/styles/scss/`.

10. Critical CSS has one global CSS file loaded at the top of every page, and is set in `<project-theme>/styles/style-critical.scss`. This should (probably) include things like the header, navigation, and hero (things that are at the top of every page and need to be loaded immediately).

Other critical CSS files are created via scss in `<project-theme>/styles/scss/critical/`. Create these as needed per template file. These generate their own individual CSS files in `<project-theme>/styles/css/critical/`, which you can include on a specific template like front-page.php or single.php

More documentation in `<project-theme>/inc/enqueue-critical-css.php`.


* When adding scss or js files, name them after the template or feature they are used on. E.g., front-page.scss for styles on front-page.php, or navigation.js for JS that controls the site navigation.



Use gulp to compile CSS and JS, and compress images

1. Open terminal at the theme directory. Run `npm install` if you haven't already.

2. After npm finishes installing packages, you can run `gulp` to compile the files and then watch for further changes.
