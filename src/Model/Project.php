<?php

/**
 * Maybe they can extend some abstract class with _data property and methods(__construct, jsonSerialize)
 */
namespace App\Model;

/**
 * TODO should implement JsonSerializable
 */
class Project
{
    /**
     * TODO change public to private or protected(if extend abstract class)
     * @var array
     */
    public $_data;

    public function __construct($data)
    {
        $this->_data = $data;
    }

    /**
     * TODO declare return type
     * @return int
     */
    public function getId()
    {
        return (int) $this->_data['id'];
    }

    /**
     * TODO change method name to jsonSerialize and change method name in project usage
     * TODO declare return type
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->_data);
    }
}
