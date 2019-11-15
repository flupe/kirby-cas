<?php

use Kirby\Cms\App;

require_once __DIR__ . '/phpCAS/CAS.php';

Kirby::plugin('flupe/kirby-cas', [
    'options' => [
        'host'    => 'cas.localhost',
        'context' => '/cas',
    ],

    'translations' => [
        'en' => [
            'kirby-cas.connect' => 'Connect through CAS',
        ],
        'fr' => [
            'kirby-cas.connect' => 'Connexion via CAS',
        ],
    ],

    'routes' => function ($kirby) {
        return [
            [
                'pattern' => '/login-cas',
                'action' => function() {
                    $kirby = App::instance();

                    phpCAS::client(
                        CAS_VERSION_2_0,
                        $kirby->option('flupe.kirby-cas.host'),
                        443,
                        $kirby->option('flupe.kirby-cas.context')
                    );

                    phpCAS::setNoCasServerValidation();

                    if (phpCAS::isAuthenticated()) {
                        $user = $kirby->users()->findBy(
                            $kirby->option('flupe.kirby-cas.user-field'),
                            phpCas::getUser()
                        );

                        if ($user != null) {
                            $user->loginPasswordless();
                            go($kirby->url('panel'));
                        }

                        else {
                            // TODO: display an error explaining no user was found
                            go($kirby->url('panel'));
                        }
                    }
                    else {
                        phpCAS::forceAuthentication();
                    }
                }
            ]
        ];
    },
]);
