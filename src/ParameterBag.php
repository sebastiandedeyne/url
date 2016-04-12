<?php

namespace Spatie\Url;

class ParameterBag
{
    /** @var array */
    protected $parameters;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public static function fromString(string $string) : ParameterBag
    {
        if (empty($string)) {
            return new static([]);
        }

        return new static(array_reduce(
            explode('&', $string),
            function (array $parameters, string $keyValuePair) : array {

                $keyValuePair = explode('=', $keyValuePair);

                $parameters[$keyValuePair[0]] = $keyValuePair[1] ?? true;

                return $parameters;

            }, []
        ));
    }

    public function get(string $key)
    {
        return $this->parameters[$key];
    }

    public function all() : array
    {
        return $this->parameters;
    }

    public function set(string $key, $value) : ParameterBag
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    public function forget(string $key) : ParameterBag
    {
        unset($this->parameters[$key]);

        return $this;
    }

    public function clear() : ParameterBag
    {
        $this->parameters = [];

        return $this;
    }

    public function isEmpty() : bool
    {
        return empty($this->parameters);
    }

    public function toString() : string
    {
        return implode('&', array_map(function ($value, string $key) : string {

            if ($value === true) {
                return $key;
            }

            return "{$key}={$value}";

        }, $this->parameters, array_keys($this->parameters)));
    }

    public function __toString() : string
    {
        return $this->toString();
    }
}
