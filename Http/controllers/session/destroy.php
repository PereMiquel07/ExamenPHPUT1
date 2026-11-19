<?php

\Core\Authenticator::class->logout();

header('location: /');
exit();