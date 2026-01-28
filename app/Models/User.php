<?php

namespace App\Models;

use App\Models\Backend\Hub;
use App\Models\Backend\Role;
use App\Models\Backend\Salary;
use App\Models\Backend\Upload;
use App\Models\Backend\Account;
use App\Models\Backend\Merchant;
use App\Traits\CommonHelperTrait;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Backend\Department;
use Spatie\Activitylog\LogOptions;
use App\Models\Backend\DeliveryMan;
use App\Models\Backend\Designation;
use Modules\Leave\Entities\LeaveAssign;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Modules\Attendance\Entities\Attendance;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity, CommonHelperTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'hub_id', 'image_id', 'facebook_id', 'google_id', 'user_type'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token',];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = ['email_verified_at' => 'datetime', 'permissions' => 'array'];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Activity Log
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('User')
            ->logOnly(['name', 'email'])
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName}");
    }

    // Get single row in Hub table.
    public function hub()
    {
        return $this->belongsTo(Hub::class, 'hub_id', 'id');
    }

    // Get single row in Department table.
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    // Get single row in Designation table.
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    // Get all row. Descending order using scope.
    public function scopeOrderByDesc($query, $data)
    {
        $query->orderBy($data, 'desc');
    }

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'image_id', 'id');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'id', 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function deliveryman()
    {
        return $this->belongsTo(DeliveryMan::class, 'id', 'user_id');
    }

    public function salary()
    {
        return $this->hasMany(Salary::class, 'user_id', 'id');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class, 'user_id', 'id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions);
    }

    public function leaves()
    {
        return $this->hasMany(LeaveAssign::class, 'department_id', 'department_id');
    }
}
