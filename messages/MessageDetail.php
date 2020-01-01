<?php
namespace app\messages;

class MessageDetail
{
	public $message;
	public $status;
	public function __construct($code,$message)
	{
		$this->status=$code;
		$this->message=$message;
	}
}