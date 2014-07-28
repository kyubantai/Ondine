<?php

namespace Ondine\IO;

/**
 * Class Response
 * @package Ondine\IO
 */
abstract class Response
{

    /**
     * @const SUCCESS
     */
    const STATUS_SUCCESS = 0x00001;

    /**
     * @const WARNING
     */
    const STATUS_WARNING = 0x00002;

    /**
     * @const ERROR
     */
    const STATUS_ERROR = 0x00003;



    /**
     * @var int $status Response status (STATUS_SUCCESS, STATUS_WARNING, STATUS_ERROR)
     */
    private $status;

    /**
     * @var string $content
     */
    protected $content;



    /**
     * Set response's status
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Return response's status
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Return response's content
     * @return String
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set response's content
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Display the response
     * @param bool $header Must send content-type header
     */
    abstract function display($header = false);

} 