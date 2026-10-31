<?php

namespace App;

use Framework\Core\ErrorHandler;

// AI-assisted integration for VAII assignment; based on cv-05 configuration.
class Configuration
{
    public const APP_NAME = 'Správa vozidiel';
    public const FW_VERSION = '3.0.7';
    public const ROOT_LAYOUT = 'root';
    public const SHOW_SQL_QUERY = false;
    public const SHOW_EXCEPTION_DETAILS = true;
    public const ERROR_HANDLER_CLASS = ErrorHandler::class;
}
