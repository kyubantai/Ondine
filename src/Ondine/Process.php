<?php

namespace Ondine;

/**
 * Class Process
 * @package Ondine
 */
class Process
{
    /**
     * @var string
     */
    private $question;

    /**
     * @var array
     */
    private $weightArray = [];

    /**
     * @var IO\Response
     */
    private $response;

    /**
     * @var string
     */
    private $format;

    /**
     * @var int
     */
    private $timeStart;

    /**
     * @var int
     */
    private $timeStop;

    /**
     * @var array
     */
    private $keywords = [];

	public function __construct() 
	{
		$this->start();
	}

    /**
     * @param string $question
     */
    public function setQuestion($question)
	{
		$this->question = $question;
	}

    /**
     * @return string
     */
    public function getQuestion()
	{
		return $this->question;
	}

    /**
     * Add a weight corresponding to the mod in weight array
     * @param string $mod
     * @param int $weight
     */
    public function addWeightTo($mod, $weight)
	{
		if (array_key_exists($mod, $this->weightArray))
		{
			$this->weightArray[$mod] += $weight;
		}
		else
		{
			$this->weightArray[$mod] = $weight;
		}

		asort($this->weightArray);
	}

    /**
     * @return array
     */
    public function getWeightArray()
	{
		return $this->weightArray;
	}

    /**
     * @param IO\Response $response
     */
    public function setResponse($response)
	{
		$this->response = $response;
	}

    /**
     * @return IO\Response
     */
    public function getResponse()
	{
		return $this->response;
	}

    /**
     * @param string $format
     */
    public function setFormat($format)
	{
		$this->format = $format;
	}

    /**
     * @return string
     */
    public function getFormat()
	{
		return $this->format;
	}

    /**
     * Start process
     * (Register start time)
     */
    private function start()
	{
		$this->timeStart = microtime();
	}

    /**
     * Stop process
     * (Register stop time)
     * @param IO\Response $response
     */
    public function stop($response)
	{
		$this->timeStop = microtime();

		$this->setResponse($response);
	}

    /**
     * Add a keyword to the array
     * @param $word
     */
    public function addKeyword($word)
    {
        $this->keywords[] = $word;
    }

    /**
     * Get the keyword array
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Save the process
     */
    public function save()
	{
        $array = [
            'question' => $this->question,
            'response' => $this->response->getContent(),
            'format'   => $this->format,
            'start'    => $this->timeStart,
            'stop'     => $this->timeStop,
            'weight'   => $this->weightArray,
            'keywords' => $this->keywords
        ];

        $json = json_encode($array);

		//TODO: Save json
	}
}