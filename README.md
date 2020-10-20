# Senses Laravel GDPR

Laravel package to handle management of GDPR permission cookies. Heavily inspired by Spatie's [laravel-cookie-consent](https://github.com/spatie/laravel-cookie-consent) package

## Installation

``` bash 
composer require senses/gdpr
```

In `config/app.php`

``` php
// Add to service providers array
Senses\Gdpr\GdprServiceProvider::class,

// Add to aliases array
'Gdpr' => Senses\Gdpr\GdprFacade::class,
```

## Usage
### Backend

In your layout file, include the `@gdprjs` directive somewhere inside your `<body>` tag.

You can then use the directive `@gdpr('category')` which acts as an if statement based on whether or not the user has accepted the cookie.

You can publish the package's config to `config/gdpr.php` with `php artisan vendor:publish`.

``` bash
php artisan vendor:publish --provider="Senses\Gdpr\GdprServiceProvider"
```

The default categories for cookies are:
``` php
'types' => [
    'necessary', 'functional', 'analytics', 'settings'
]
```

You can change this in your published config, along with the cookie name and lifetime.

You can disable the plugin by setting `GDPR_ENABLED` to `false` in your `.env.` file.

### Frontend

Provided the `@gdprjs` directive is present, you can manipulate the gdpr settings via javascript.

The package binds a `laravelGdpr` object to the `window` object. Allowing you to work with the package from there.

It's best to reload the page once you're done changing these settings in order for the user's configuration to come into effect.

The `laravelGdpr` object has two methods inside it:

`laravelGdpr.get()` will return the user's entire config.

`laravelGdpr.set(category, value)` accepts two parameters, `category` and `value`. `value` should be boolean.

The package is frontend-agnostic, allowing you to use your own CSS and JS to construct the GDPR permissions modal.

When one of your toggles or checkboxes is changed, you will need to call the `laravelGdpr.set()` method.

**Quick Example:**

``` js
document.querySelector('input[type="checkbox"]#third_party').addEventListener('click', function(e) {
    laravelGdpr.set('third_party', e.target.checked);
});
```

There is a full example Vue component available on [codesandbox](https://codesandbox.io/s/senses-gdpr-example-modal-el7dw?file=/src/components/GdprModal.vue)
