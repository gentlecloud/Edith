<?php
namespace Gentle\Edith\Traits;

use Illuminate\Support\Collection;

trait HasPermissions
{
    /**
     * Get all permissions of user.
     * @return mixed
     */
    public function allPermissions(): Collection
    {
        return $this->permissions()->with('permissions')->get()->pluck('permissions')->flatten();
    }

    /**
     * Get all menus of user.
     * @return mixed
     */
    public function allMenus(): Collection
    {
        return $this->menus()->with('menus')->get()->pluck('menus')->flatten();
    }

    /**
     * Check the user has permission.
     * @param $abilities
     * @return bool
     */
    public function can($abilities): bool
    {
        if (empty($abilities)) {
            return false;
        }

        return $this->allPermissions()->pluck('uri')->contains($abilities);
    }

    /**
     * Check the user has no permission.
     * @param $abilities
     * @return bool
     */
    public function cannot($abilities): bool
    {
        return !$this->can($abilities);
    }

    /**
     * @return bool
     */
    public function isSuperAdministrator(): bool
    {
        return $this->id === config('edith.auth.admin_id');
    }
}
