<?php

namespace Ondine;

class Process
{
	private $question;

	private $weightArray = [];

	private $response;

	private $format;

	private $timeStart;

	private $timeStop;

	public function __construct() 
	{
		$this->start();
	}

	public function setQuestion($question)
	{
		$this->question = $question;
	}

	public function getQuestion()
	{
		return $this->question;
	}

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

	public function getWeightArray()
	{
		return $this->weightArray;
	}

	public function setResponse($response)
	{
		$this->response = $response;
	}

	public function getResponse()
	{
		return $this->response;
	}

	public function setFormat($format)
	{
		$this->format = $format;
	}

	public function getFormat()
	{
		return $this->format;
	}

	private function start()
	{
		$this->timeStart = microtime();
	}

	public function stop($response)
	{
		$this->timeStop = microtime();

		$this->setResponse($response);
	}

	public function save()
	{
		//TODO:
	}
}