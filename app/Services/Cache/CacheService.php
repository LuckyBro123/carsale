<?php

namespace App\Services\Cache;

use Closure;
use DateInterval;
use DateTimeInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Cache\TaggedCache;

class CacheService {
	protected array $tags = [];
	protected string $prefix = '';

	public static function tags(...$tags): self|TaggedCache {
		if (Config::get('app.FREE_HOSTING', false)) {
			return (new self)->handleTags($tags);
		}

		return Cache::tags($tags);
	}

	protected function handleTags($tags): self {
		$this->tags = array_map(function ($tag) {
			return is_array($tag) ? implode('_', $tag) : $tag;
		}, $tags);

		$this->prefix = implode('_', $this->tags) . '_';

		return $this;
	}

	public function remember(string $key, DateTimeInterface|DateInterval|int|null $ttl, Closure $callback): mixed {
		return Cache::remember($this->prefix . $key, $ttl, $callback);
	}

	public function rememberForever(string $key, Closure $callback): mixed {
		return Cache::rememberForever($this->prefix . $key, $callback);
	}

	public function forever(string $key, $value): mixed {
		return Cache::forever($this->prefix . $key, $value);
	}

	public function flush(): bool {
		$storage = Cache::getStore();

		if (method_exists($storage, 'all')) {
			$keys = array_filter($storage->all(), function ($key) {
				return str_starts_with($key, $this->prefix);
			}, ARRAY_FILTER_USE_KEY);

			foreach ($keys as $key => $value) {
				Cache::forget($key);
			}
		} else {
			// Для драйверов, которые не поддерживают метод all()
			Cache::flush();
		}

		return true;
	}

	public function forget(string $key): bool {
		return Cache::forget($this->prefix . $key);
	}

	public function has(string $key): bool {
		return Cache::has($this->prefix . $key);
	}

	public function put(string $key, mixed $value, DateTimeInterface|DateInterval|int|null $ttl = null): bool {
		return Cache::put($this->prefix . $key, $value, $ttl);
	}
}