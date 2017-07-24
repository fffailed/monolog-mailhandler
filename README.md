### install
```
composer update
```

### example
```php
namespace libraries;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

$config = require 'config.php';
$logger = new Logger('channel');

$to = ['to1@163.com', 'to2@163.com'];

$logger->pushHandler(new PHPMailerHandler($to, $config));

$logger->pushHandler($handler = new RotatingFileHandler('test.log', 30));

$formatter = "[logger]%channel% [time]%datetime% [level]%level_name% [msg]%message% %context% %extra%";
$handler->setFormatter(new LineFormatter($formatter, 'Y-m-d H:i:s.ss', true, true));

```
