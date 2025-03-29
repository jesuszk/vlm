<?php

function path()
{
    return new class {
        function images($path = '')
        {
            return $_ENV["APP_URL"] . "/public/images/{$path}";
        }

        function js($path = '')
        {
            return $_ENV["APP_URL"]  . "/public/js{$path}";
        }

        function css($path = '')
        {
            return $_ENV["APP_URL"] . "/public/css{$path}";
        }
    };
}
