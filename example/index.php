<?php
define('FCPATH',   dirname(__FILE__) . DIRECTORY_SEPARATOR);

require FCPATH . 'vendor/autoload.php';

$to = ['to1@163.com'];
$mailConf = [
	'subject'        => 'subject',
	'charset'        => 'UTF-8',
	'port'           => 25,
	'smtpAuth'       => true,
	'host'           => 'smtp.163.com',
	'username'       => 'test@163.com',
	'password'       => 'password',
	'replytoAddress' => 'test@163.com',
	'replytoName'    => 'reply to name',
	'fromAddress'    => 'test@163.com',
	'fromName'       => 'from name'
];

$logger = new \Monolog\Logger('testlog');

// send mail
$logger->pushHandler(new \libraries\PHPMailerHandler($to, $mailConf));

// write file
$logger->pushHandler(
	$handler = new \Monolog\Handler\RotatingFileHandler(FCPATH . 'logs/test.log', 10)
);

$handler->setFormatter(new \Monolog\Formatter\LineFormatter(
	"[logger]%channel% [time]%datetime% [level]%level_name% [msg]%message% %context%" . PHP_EOL,
	'Y-m-d H:i:s.ss',
	true,
	true
));

$logger->info('test monolog mailhandler', ['context' => 'context 123']);

