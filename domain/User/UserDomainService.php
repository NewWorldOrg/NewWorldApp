<?php

declare(strict_types=1);

namespace Domain\User;

class UserDomainService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserByIdWithMedicationHistories(Id $id): UserAndMedicationHistory
    {
        return $this->userRepository->getUserByIdWithMedicationHistories($id);
    }

    public function getUserByUserId(UserId $userId): User
    {
        return $this->userRepository->getUserByUserId($userId);
    }

    public function userRegister(
        Id $id,
        UserHashedPassword $password,
        UserStatus $userStatus,
    ): bool {
        return $this->userRepository->userRegister(
            $id,
            $password,
            $userStatus,
        );
    }
}