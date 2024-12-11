<?php

namespace App\Models\Import;

use App\Contracts\OnlyForDataImport;
use App\Models\Import\Abstracts\BaseImportModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;

/**
 * @property int $ID
 * @property string $username
 * @property string $pass
 * @property string $email
 * @property string $nev
 * @property string $ir_szam
 * @property string $telepules
 * @property string $cim
 * @property string|null $telefon_szam
 * @property string|null $weblap
 * @property int $nyilvanos
 * @property-read mixed $password
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UsersOld newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UsersOld newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UsersOld query()
 *
 * @mixin \Eloquent
 */
class UsersOld extends BaseImportModel implements OnlyForDataImport
{
    protected $table = 'users_old';

    public function getTargetModelName(): string
    {
        return User::class;
    }

    public function toMappedRow(): array
    {
        return [
            'id' => $this->ID,
            'name' => $this->nev,
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->pass,
            'zip' => $this->ir_szam,
            'city' => $this->telepules,
            'address' => $this->cim,
            'phone' => $this->telefon_szam,
            'own_site_address' => $this->weblap,
            'site_is_public' => $this->nyilvanos,
            'email_verified_at' => now(),
        ];
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Hash::make($value),
        );
    }

    protected function irSzam(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?: null,
        );
    }

    protected function telefonSzam(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?: null,
        );
    }
}
