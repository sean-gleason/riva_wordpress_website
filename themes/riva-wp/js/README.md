# Javascript Bundling

You can optionally use modular js and/or non-modular js at the same time. The gulp build process leverages webpack to bundle js together efficiently.

ALL of the scripts imported to `js/main.js` get bundled together into a minified, source-mapped `dist/js/main.js`. In fact, any js file you add _directly_ inside of `js/` will be processed and an associated file will be output to `dist/js/`.

This is useful if you need to split up some js between multiple files.

Most of the time you won't want or need to do this in Drupal, but there are special cases where this can by handy. In Wordpress, this splitting is more common (enqueue only admin js for admin areas, etc).

## Modular JS

This is the preferred and newer way of handling scripts.

Modular js uses exports and imports: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Modules and allows you to leverage libraries that work this way, including most npm packages.

`js/main.js` is the typical entry point for js. Modules are imported together there. Webpack goes through all of the imported js and compiles together only the ncessary js in the output minified, source-mapped file.

Note, you can and should import node modules directly. This is the preferred way to use third-party js libraries. Add them to the package.json, and once installed, you can simply use `import 'name-of-npm-package'` to import it. See the top of `js/main.js` for examples.

### jQuery

In both Drupal and Wordpress, webpack is setup to assume the presence of jQuery already, which should be loading as a dependency before any js that imports it. In Drupal this is setup in the theme libraries system to leverage Drupal's jQuery. In Wordpress this is setup as a dependency in `wp_enqueue_script`. You still need to "import" it in modular js, just know that webpack will pass the existing jQuery from your CMS in seamlessly for that requirement.

## Non-Modular JS

If you need to pull in unbundled JS, via a theme library with `attach_library` in your twig (in Drupal), for example, you may do so, but this is usually discouraged.

Simply add the required js file to `js/`, `js/special.js`. Then reference the associated output file at `dist/js/special.js` in your enqueue or attach_library, etc.

Any js that you do not explicitly import into `js/main.js` (or any other top-level .js files direclty inside of `js/`) will not be processed or `touched` at all, and you may direclty reference those files with `attach_library` if that is somehow prefereable to the method described above.

Most component js should be easy to convert to a modular format, and this is the preferred solution.

At the very least, you should be able to `import` an IIFE js file and the js in that file **will execute at the line of import**.

## Converting to Modular JS

Non-modular scripts are typically IIFEs (Immediately Invoked Function Expression) sometimes called Self-Invoked Functions. They don't export or import anything.

Conversion, in the simplest sense, of non-modular js into a module can be accomplished by removing any surrounding IIFE wrapper syntax and replacing it with export default syntax, then importing the module in `js/main.js`, and invoking it where you want it to run.

For example, the standard format for a typical IIFE looks like this:

```
  ;(function ($) {

    // some js

  })(jQuery);
```

And the same, as a very simple module looks like this:

```
  import $ from 'jQuery';

  export default () => {

    // some js

  }
```

You can see that the major difference is really around the "scaffolding" or the wrappers of the js that does the actual work.

The example includes jQuery as further illustration, since we tend to use jQuery in most of our js.

Once you've made a conversion like this, you still must import and invoke the module in `js/main.js` for it to run. See examples under **LIBRARY IMPORTS** and **COMPONENT IMPORTS** in `js/main.js`. You simply give the default exported function a sensible name and then run that function where you want the code to execute.

## Production Code

For Drupal, your project should ultimately be using CSS and JS aggregation and compression, typically through the AdvAgg module. Similar solutions may be available for Wordpress.
