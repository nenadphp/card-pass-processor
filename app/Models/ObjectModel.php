<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectModel extends Model
{
    use HasFactory;

    protected $table = 'objects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'object_uuid',
        'name',
        'is_active'
    ];

    /**
     * @param string $objectUuid
     * @return mixed
     */
    public function isObjectValid(string $objectUuid)
    {
        return self::where('object_uuid', $objectUuid)
            ->where('is_active', '1')
            ->first();
    }
}
