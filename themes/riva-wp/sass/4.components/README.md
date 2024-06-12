# Components

What's a component? Just about anything can be a component. Components can and often do contain other components.

In this organizational structure, a component is anything that overrides global styling, targets a specific area, control, non-global region, feature, widget, etc.

In most cases, the name of a component file should mirror the top level selector in that file. So a component that styles .`accordion` should live in a file called `_paccordion.scss`.

Feel free to group components into subfolders as makes sense.

Components should be relatively self-contained. They should not rely too much on external references without good reason.

Prefer composition via @mixin (as opposed to strong reliance on the cascade) if you wish to replicate a common decorative feature.

Avoid the use of @extend.
