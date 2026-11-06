<?php

namespace App;

use Framework\Core\ErrorHandler;
use Framework\DB\DefaultConventions;

// AI-assisted extension for database configuration: ChatGPT, VAII assignment 6.
class Configuration
{
    public const APP_NAME = 'Sprava vozidiel';
    public const FW_VERSION = '3.0.7';
    public const DB_HOST = 'db';
    public const DB_NAME = 'vozidla_db';
    public const DB_USER = 'vaii_user';
    public const DB_PASS = 'vaii_dev_password';
    public const DB_CONVENTIONS_CLASS = DefaultConventions::class;
    public const ROOT_LAYOUT = 'root';
    public const SHOW_SQL_QUERY = false;
    public const SHOW_EXCEPTION_DETAILS = true;
    public const ERROR_HANDLER_CLASS = ErrorHandler::class;
}
