<?php

use Core\Authenticator;

Authenticator::class->logout();

header('location: /');
exit();