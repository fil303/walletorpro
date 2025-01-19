<?php

return [
    // PayPal
    [
        "title" => "PayPal",
        "slug"  => "paypal",
        "icon"  => "images/payment_method/paypal.png",
        "currency" => ["USD"],
        "attributes" => [
            [
                "title"     => "Paypal Email",
                "slug"      => "paypal_email",
                "type"      => "input",
                "required"  => true,
                "readonly"  => false,
            ],
            [
                "title"     => "Paypal Client ID",
                "slug"      => "paypal_client_id",
                "type"      => "input",
                "required"  => true,
                "readonly"  => false,
            ],
            [
                "title"     => "Client Secret",
                "slug"      => "paypal_client_secret",
                "type"      => "input",
                "required"  => true,
                "readonly"  => false,
            ],
            [
                "title"     => "Mode",
                "slug"      => "paypal_mode",
                "type"      => "select",
                "required"  => true,
                "readonly"  => false,
            ]
        ]
    ],

    // Stripe
    [
        "title" => "Stripe",
        "slug"  => "stripe",
        "icon"  => "images/payment_method/stripe.png",
        "currency" => ["EUR","USD"],
        "attributes" => [
            [
                "title"     => "Stripe Secret Key",
                "slug"      => "stripe_secret_key",
                "type"      => "input",
                "required"  => true,
                "readonly"  => false,
            ],
            [
                "title"     => "Stripe Publishable Key",
                "slug"      => "stripe_public_key",
                "type"      => "input",
                "required"  => true,
                "readonly"  => false,
            ],
            [
                "title"     => "Stripe Webhook Signing Secret",
                "slug"      => "stripe_webhook_endpoint_secret",
                "type"      => "input",
                "required"  => true,
                "readonly"  => false,
            ]
        ]
    ],
    
    // Perfect Money
    [
        "title" => "Perfect Money",
        "slug"  => "perfect_money",
        "icon"  => "images/payment_method/perfect-money.png", 
        "currency" => ["EUR","USD"],
        "attributes" => [
            [
                "title"     => "PM USD Wallet",
                "slug"      => "pm_usd_wallet",
                "type"      => "input",
                "required"  => true,
                "readonly"  => false,
            ],
            [
                "title"     => "PM EUR Wallet",
                "slug"      => "pm_eur_wallet",
                "type"      => "input",
                "required"  => true,
                "readonly"  => false,
            ],
            [
                "title"     => "Alternate Passphrase",
                "slug"      => "alternate_passphrase",
                "type"      => "input",
                "required"  => true,
                "readonly"  => false,
            ]
        ]
    ]
];