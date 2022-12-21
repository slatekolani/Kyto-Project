<?php

namespace App\Models\Auth;

use App\Models\Auth\RoleAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\Relationship\RoleRelationship;
use App\Models\Auth\Attribute\RoleAttribute;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Role extends Model implements AuditableContract
{
    use  RoleAttribute, RoleRelationship, Auditable;


    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    /**
     * @var array
     */
    protected $auditableEvents = [
        'deleted',
        'updated',
        'restored',
    ];

//    Relation for the Role having many users. As pivot relation with its user
    public function User()
    {
        return $this->belongsToMany(User::class);
    }

}
