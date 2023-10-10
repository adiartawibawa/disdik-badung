<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    use HasUuids;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'guard_name',
    ];

    const ROOT = 'root';
    const ADMIN = 'admin';
    const USER = 'user';

    public static function defaultRoles()
    {
        return [
            'root', 'admin', 'user'
        ];
    }
}
