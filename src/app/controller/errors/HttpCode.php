<?php

namespace GPD\App\Controller\Error;

enum HttpCode: int
{
    case Code404  = 404;
    case Code403  = 403;
}
