<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AdminUser;
use App\Services\Service as AppService;
use App\Services\Interfaces\AdminUserServiceInterface;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

class AdminUserService extends AppService implements AdminUserServiceInterface
{

    /**
     * Get all users.
     *
     * @return LengthAwarePaginator
     */
    public function getUsers(): LengthAwarePaginator {

        return AdminUser::paginate(15);

    }

    /**
     * Create a user.
     *
     * @param Request $request
     * @return AdminUser
     * @throws Exception
     */
    public function createUser(Request $request): AdminUser
    {
        $params = $request->only(['user_id', 'password', 'name', 'role', 'status']);

        $result = AdminUser::create([
            'user_id' => $params['user_id'],
            'password' => Hash::make($params['password']),
            'name' => $params['name'],
            'role' => $params['role'],
            'status' => $params['status'],
        ]);

        if (empty($result)) {
            throw new Exception('Failed to create');
        }

        return $result;
    }

    /**
     * Update the user.
     *
     * @param AdminUser $adminUser
     * @param Request $request
     * @throws Exception
     */
    public function updateUser(AdminUser $adminUser, Request $request)
    {
        $params = $request->only(['user_id', 'password', 'name', 'role', 'status']);

        $data = [
            'user_id' => $params['user_id'],
            'name' => $params['name'],
            'role' => $params['role'],
            'status' => $params['status'],
        ];
        if (!empty($params['password'])) {
            $data['password'] = Hash::make($params['password']);
        }
        if (!$adminUser->update($data)) {
            throw new Exception('Failed to update');
        }

    }

    /**
     * Delete the user.
     *
     * @param AdminUser $adminUser
     * @throws Exception
     */
    public function deleteUser(AdminUser $adminUser)
    {
        if (!$adminUser->delete()) {
            throw new Exception('Failed to delete');
        }
    }
}
