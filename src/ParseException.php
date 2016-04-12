<?php

namespace Spatie\Url;

class ParseException extends \Exception
{
    public static function url(string $url)
    {
        throw new static("Couldn't parse url `{$url}`");
    }
}
