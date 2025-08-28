<?php

namespace App\Enums;

enum ContactStatus: string { case OPEN='open'; case PENDING='pending'; case CLOSED='closed'; case SPAM='spam'; }
