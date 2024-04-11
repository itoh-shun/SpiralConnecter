<?php

class HttpRequestParameter extends stdClass
{
    public function __construct(array $array = [])
    {
        foreach ($array as $key => $val) {
            $this->set($key, $val);
        }
    }

    public function delete($key){
        unset($this->{$key});
    }

    public function set($key, $value)
    {
        $this->{$key} = $value;
    }

    public function get($key)
    {
        if (!isset($this->{$key})) {
            return null;
        }
        return $this->{$key};
    }

    public function toJson()
    {
        return json_encode((array) $this, true);
    }

    public function toArray()
    {
        return (array) $this;
    }

    public function remake()
    {
        return new self($this->toArray());
    }
}
