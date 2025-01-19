<?php

namespace App\Notifications;

use Illuminate\Contracts\Auth\MustVerifyEmail;

interface MustEmailVerify extends MustVerifyEmail
{
    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getKey();
}
