<?php
function fail(int $status, string $logMessage): void
{
    error_log($logMessage);
}
