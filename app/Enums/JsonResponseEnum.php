<?php

declare(strict_types = 1);

namespace App\Enums;

enum JsonResponseEnum: string
{
	case DELETE_CANDIDATE_SUCCESS = 'Candidate deleted successfully.';
	case DELETE_MISSION_SUCCESS = 'Mission deleted successfully.';
	case CREATE_CANDIDATE_SUCCESS = 'Candidate created successfully.';
	case CREATE_MISSION_SUCCESS = 'Mission created successfully.';
	case CREATE_ERROR = 'The given data was invalid.';
	case UPDATE_CANDIDATE_SUCCESS = 'Candidate updated successfully.';
	case UPDATE_MISSION_SUCCESS = 'Mission updated successfully.';
	case CANDIDATE_NOT_FOUND = 'Candidate not found.';
	case MISSION_NOT_FOUND = 'Mission not found.';
}
