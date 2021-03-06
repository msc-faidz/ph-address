<?php

namespace Dmn\PhAddress\Models;

use Dmn\PhAddress\Models\Traits\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipality extends Model
{
    use Address;

    protected $table = 'municipalities';

    protected $primaryKey = 'code';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * Barangays relationship
     *
     * @return HasMany
     */
    public function barangays(): HasMany
    {
        return $this->hasMany(
            Barangay::class
        );
    }
}
