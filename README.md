# reactphp-x-redis-cache

## install

```
composer require reactphp-x/redis-cache -vvv
```


## Usage

```php
use Clue\React\Redis\RedisClient;
use ReactphpX\RedisCache\RedisCache;
$redis = new RedisClient('redis://:h%40llo@localhost');
// $redis = new RedisClient('redis://ignored:h%40llo@localhost');
// $redis = new RedisClient('redis://localhost?password=h%40llo');
// $redis = new RedisClient('redis://localhost/2');
// $redis = new RedisClient('redis://localhost?db=2');

$redisCache = new RedisCache($redis);
```

see [CacheInterface](https://github.com/reactphp/cache?tab=readme-ov-file#usage)

## License
MIT
