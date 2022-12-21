<?php

namespace App\Models\Auth;

use App\Models\Auth\Attribute\UserAttribute;
use App\Models\Auth\Relationship\UserRelationship;
use App\Models\System\Relationship\GeneralDocumentRelationship;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use App\Models\tourOperatorRating\tourOperatorRating;
use App\Models\tourOperators\tourOperators;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Auditable;
use Webpatser\Uuid\Uuid;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * @property mixed confirmation_code
 */
class User extends Authenticatable implements  AuditableContract
{
    use Notifiable, UserAttribute, UserRelationship, Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['uuid'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * @var array
     */
    protected $auditableEvents = [
        'deleted',
        'updated',
        'restored',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    //Relation for the user having tourOperator Companies.(Has many)

    public function tourOperators()
    {
        return $this->hasMany(tourOperators::class);
    }

//Relation for the user to its role in the system as pivot relation

    public function Role()
    {
        return $this->belongsToMany(Role::class);
    }

    /*A user can have many blogs*/
    public function tourOperatorsBlogs()
    {
        return $this->hasMany(tourOperatorsBlogs::class);
    }

//    A user can create many rating to a tour Operator
    public function tourOperatorRating()
    {
        return $this->hasMany(tourOperatorRating::class);
    }



}
