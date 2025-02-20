<?php

namespace App\Providers;

use Closure;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;

class UserServiceProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @return Authenticatable|null
     */
    public function retrieveByCredentials(#[\SensitiveParameter] array $credentials)
    {
        $credentials = array_filter(
            $credentials,
            fn ($key) => !str_contains($key, 'password'),
            ARRAY_FILTER_USE_KEY
        );

        if (empty($credentials)) {
            return null;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->newModelQuery();

        foreach ($credentials as $key => $value) {
            if (is_array($value) || $value instanceof Arrayable) {
                $query->whereIn($key, $value);
            } elseif ($value instanceof Closure) {
                $value($query);
            } elseif ($key === 'email') {
                $query->where(fn (Builder $q) => $q->where('email', $value)
                    ->orWhere('username', $value)
                );
            } else {
                $query->where($key, $value);
            }
        }

        /** @var Authenticatable|null $model */
        $model = $query->first();

        return $model;
    }

    public function validateCredentials(Authenticatable $user, #[\SensitiveParameter] array $credentials)
    {
        $credentials['password'] = md5($credentials['password']);

        return parent::validateCredentials($user, $credentials);
    }

    protected function newModelQuery($model = null)
    {
        $query = parent::newModelQuery($model);

        with($query, fn (Builder $q) => $q->whereNotNull('email_verified_at'));

        return $query;
    }
}
