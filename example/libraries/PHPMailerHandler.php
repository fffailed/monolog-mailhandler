<?php
namespace libraries;

use \PHPMailer;
use \phpmailerException;
use Monolog\Logger;
use Monolog\Handler\MailHandler;

class PHPMailerHandler extends MailHandler
{
	private $to;

	private $conf;

	public function __construct(array $to, array $conf, $bubble = true, $level = Logger::DEBUG)
	{
		parent::__construct($level, $bubble);

		if (empty($to) || empty($conf)) {
			throw new \InvalidArgumentException('PHPMailerHandler params error');
		}

		$this->to   = $to;
		$this->conf = $conf;
	}

	protected function send($content, array $records)
	{
		$mailer = new PHPMailer(true);

		$mailer->ClearAllRecipients();

		$mailer->IsSMTP();
		$mailer->IsHTML(true);

		$mailer->SMTPAuth  = isset($this->conf['smtpAuth']) ? $this->conf['smtpAuth'] : false;

		$mailer->CharSet   = isset($this->conf['charset']) ? $this->conf['charset'] : 'UTF-8';
		$mailer->Port      = isset($this->conf['port']) ? $this->conf['port'] : 25;
		$mailer->Host      = $this->conf['host'];
		$mailer->Username  = $this->conf['username'];
		$mailer->Password  = $this->conf['password'];
		$mailer->From      = $this->conf['fromAddress'];
		$mailer->FromName  = $this->conf['fromName'];
		$mailer->Subject   = $this->conf['subject'];
		$mailer->Body      = $content;

		foreach ($this->to as $v) $mailer->AddAddress($v);

		if (isset($this->conf['replytoAddress']) && isset($this->conf['replytoName'])) {
			$mailer->AddReplyTo($this->conf['replytoAddress'], $this->conf['replytoName']);
		}

		if (isset($this->conf['debug'])) {
			$mailer->SMTPDebug = $this->conf['debug'];
		}

		try {
			$mailer->send();
		} catch (phpmailerException $e) {
			throw new \InvalidArgumentException('PHPMailerHandler send failed');
		}

	}
}

