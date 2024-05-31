<?php

declare(strict_types = 1);

namespace App\Enums;

enum JsonResponse: string
{
	case DELETE_SUCCESS = 'Candidate deleted successfully.';
	case DELETE_MISSION_SUCCESS = 'Mission deleted successfully.';
	case CREATE_SUCCESS = 'Candidate created successfully.';
	case MISSION_CREATE_SUCCESS = 'Mission created successfully.';
	case CREATE_ERROR = 'The given data was invalid.';
	case UPDATE_SUCCESS = 'Candidate updated successfully.';
	case NOT_FOUND = 'Candidate not found.';
}
