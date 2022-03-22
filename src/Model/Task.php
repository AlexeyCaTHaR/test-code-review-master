<?php

/**
 * Maybe they can extend some abstract class with _data property and methods(__construct, jsonSerialize)
 */
namespace App\Model;

class Task implements \JsonSerializable
{
    /**
     * @var array
     */
    private $_data;

    public function __construct($data)
    {
        $this->_data = $data;
    }

    /**
     * TODO missed json_encode or another method and return string
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->_data;
    }
}
