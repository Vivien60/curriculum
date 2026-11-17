<?php
// display an error
return static function ($httpErrorCode, $errorMessage): void
{
    http_response_code($httpErrorCode);
    echo ($errorMessage);
};
