<?php
namespace Edith\Admin\Models;

use Edith\Admin\Casts\Hash;
use Edith\Admin\Contracts\HasEdithToken as HasEdithTokenContract;
use Edith\Admin\Support\GoogleAuthenticator;
use Edith\Admin\Traits\DateTimeFormatter;
use Edith\Admin\Traits\HasEdithToken;
use Edith\Admin\Traits\HasPermissions;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class EdithAdmin extends Model implements AuthenticatableContract, HasEdithTokenContract
{
    use Authenticatable, HasEdithToken, HasPermissions, DateTimeFormatter, Notifiable, SoftDeletes;

    /**
     * 属性黑名单
     * @var string[]
     */
    protected $guarded = ['role_ids'];

    /**
     * The attributes that should be hidden for arrays.
     * @var string[]
     */
    protected $hidden = [
        'password', 'remember_token', 'google_secret'
    ];

    protected $appends = [];

    /**
     * 默认加载的关联
     *
     * @var array
     */
    protected $with = ['log'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'password' => Hash::class,
        'lasted_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     * @return string|null
     */
    public function getGoogleQrcodeAttribute() {
        return empty($this->google_secret) ? null : (new GoogleAuthenticator)->getQRCodeGoogleUrl($this->google_secret);
    }

    /**
     * the User has and belongs to many roles.
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(EdithRole::class, EdithRoleUser::class, 'user_id', 'role_id');
    }

    /**
     * the User has and belongs to many menus.
     * @return BelongsToMany
     */
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(EdithRoleMenu::class, EdithRoleUser::class, 'user_id', 'role_id', '', 'role_id');
    }

    /**
     * the User has and belongs to many permissions.
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(EdithRolePermission::class, EdithRoleUser::class, 'user_id', 'role_id', '', 'role_id');
    }

    /**
     * @return hasOne
     */
    public function log()
    {
        return $this->hasOne(EdithAdminLogin::class, 'admin_id', 'id')->latest();
    }
}
