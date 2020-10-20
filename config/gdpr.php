<?php

return [

    /* 
     * Allow disabling of the plugin. This will always show content in @gdpr directives.
     */
    'enabled' => env('GDPR_ENABLED', true),

    /*
     * Name of the cookie stored on the user's end.
     */
    'cookie_name' => 'laravel_gdpr',

    /*
     * Duration (in days) the cookie will be stored.
     */
    'cookie_lifetime' => 365 * 20,

    /*
     * Categories of data the end user has control over
	 * and their default values.
     */
    'defaults' => [
        'necessary' => true,
		'functional' => false,
		'analytics' => false,
		'settings' => false
    ]
];