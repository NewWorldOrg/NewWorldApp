<?php

declare(strict_types=1);

namespace Domain\AdminUsers;

use Courage\CoInt\CoPositiveInteger;
use Illuminate\Pagination\LengthAwarePaginator;

interface AdminUserRepository
{
    public function getPaginator(): LengthAwarePaginator;
    public function create(
        AdminUserId $adminUserId,
        AdminUserHashedPassword $adminUserHashedPassWord,
        AdminUserName $adminUserName,
        AdminUserRole $adminUserRole,
        AdminUserStatus $adminUserStatus
    ): AdminUser;
    public function update(AdminUser $adminUser): AdminUser;
    public function delete(AdminId $adminId): CoPositiveInteger;
}