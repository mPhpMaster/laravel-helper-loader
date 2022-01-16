<?php

if ( !function_exists('isRunningInConsole') ) {
    /**
     * @return bool
     */
    function isRunningInConsole()
    {
        static $runningInConsole = null;

        if ( isset($_ENV['APP_RUNNING_IN_CONSOLE']) || isset($_SERVER['APP_RUNNING_IN_CONSOLE']) ) {
            return ($runningInConsole = $_ENV['APP_RUNNING_IN_CONSOLE']) ||
                   ($runningInConsole = $_SERVER['APP_RUNNING_IN_CONSOLE']) === 'true';
        }

        return $runningInConsole = $runningInConsole ?: (
            \Illuminate\Support\Env::get('APP_RUNNING_IN_CONSOLE') ??
            (\PHP_SAPI === 'cli' || \PHP_SAPI === 'phpdbg' || in_array(php_sapi_name(), ['cli', 'phpdb']))
        );
    }
}
