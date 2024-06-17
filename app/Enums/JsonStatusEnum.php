<?php

declare(strict_types = 1);

namespace App\Enums;

enum JsonStatusEnum: int
{
	case SUCCESS = 200;
	case NOT_FOUND = 404;
	case UNPROCESSABLE = 422;
}
