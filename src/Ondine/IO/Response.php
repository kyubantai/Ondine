<?php

namespace Ondine\IO;
use Ondine\Engine;

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


    public function __construct($content, $status=self::STATUS_SUCCESS)
    {
        $this->setContent($content);
        $this->setStatus($status);
    }

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
     * Return an HTTP response code corresponding to the specified status
     * @param int $status
     * @return int
     */
    public static function statusToCode($status)
    {
        switch($status)
        {
            case self::STATUS_SUCCESS:
            case self::STATUS_WARNING:
                return 200;
                break;
            case self::STATUS_ERROR:
                return 500;
                break;
            default:

                return 0;
        }
    }



    /**
     * Return a Response child corresponding to the format
     * @param string $format
     * @param string $message
     * @param int $status
     * @return Response
     */
    public static function getFormatedResponse($format, $message, $status)
    {
        switch($format)
        {
            case Engine::FORMAT_JSON:
                return new JSONResponse($message, $status);
                break;
            case Engine::FORMAT_XML:
                //TODO:
                break;
            case Engine::FORMAT_HTML:
                //TODO:
                break;
            case Engine::FORMAT_TEXT:
                //TODO:
                break;
        }
    }



    /**
     * Display the response
     * @param bool $header Must send content-type header
     */
    abstract function display($header = false);

} 