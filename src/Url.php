<?php

namespace Spatie\Url;

use Spatie\Url\ParameterBag;

class Url
{
    /** @var string */
    protected $scheme;

    /** @var string */
    protected $host;

    /** @var string */
    protected $path;

    /** @var \Spatie\Url\ParameterBag */
    protected $query;

    /** @var string */
    protected $fragment;

    public function __construct(
        string $scheme = '',
        string $host = '',
        string $path = '',
        string $query = '',
        string $fragment = ''
    ) {
        $this->scheme = $scheme;
        $this->host = $host;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
    }

    public static function parse(string $url) : Url
    {
        $url = parse_url($url);

        if ($url === false) {
            throw ParseException::url($url);
        }

        return new static(
            $url['scheme'] ?? '',
            $url['host'] ?? '',
            $url['path'] ?? '',
            ParameterBag::fromString($url['query'] ?? ''),
            $url['fragment'] ?? ''
        );
    }

    public function scheme() : string
    {
        return $this->scheme;
    }

    public function host() : string
    {
        return $this->host;
    }

    public function path() : string
    {
        return $this->path;
    }

    public function query() : ParameterBag
    {
        return $this->query;
    }

    public function fragment() : string
    {
        return $this->fragment;
    }

    public function __toString() : string
    {
        $parts = [];

        if ($this->scheme) {
            $parts[] = $this->scheme . '://';
        }

        if ($this->host) {
            $parts[] = $this->host;
        }

        if ($this->path) {
            $parts[] = $this->path;
        }

        if (!$this->query->isEmpty()) {
            $parts[] = '?' . $this->query->toString();
        }

        if ($this->fragment) {
            $parts[] = '#' . $this->fragment;
        }

        return implode('', $parts);
    }
}
