<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransfer\MedicationHistory\MedicationHistoryDetail;
use App\DataTransfer\MedicationHistory\MedicationHistoryDetailList;
use App\DataTransfer\MedicationHistory\MedicationHistoryDetailPaginator;
use Domain\Common\Paginator\Paginate;
use Domain\Drug\DrugDomainService;
use Domain\Drug\DrugName;
use Domain\MedicationHistory\MedicationHistory;
use Domain\MedicationHistory\MedicationHistoryAmount;
use Domain\MedicationHistory\MedicationHistoryDomainService;
use Domain\User\Id;
use App\Services\Service as AppService;
use App\Services\Interfaces\MedicationHistoryServiceInterface;
use Domain\User\UserDomainService;

class MedicationHistoryService extends AppService implements MedicationHistoryServiceInterface
{
    public function __construct(
        private MedicationHistoryDomainService $medicationHistoryDomainService,
        private DrugDomainService $drugDomainService,
        private UserDomainService $userDomainService,
    ){
    }

    /**
     * Get all medication history
     *
     * @param Paginate $paginate
     * @return MedicationHistoryDetailList
     */
    public function getMedicationHistoryPaginator(Paginate $paginate): MedicationHistoryDetailPaginator
    {
        $result = $this->medicationHistoryDomainService->getPaginate($paginate);

        $medicationHistoryDetailList = new MedicationHistoryDetailList([]);

        foreach ($result as $key => $item) {
            /** @var MedicationHistory $item */
            $drug = $this->drugDomainService->show($item->getDrugId());
            $user = $this->userDomainService->getUserById($item->getUserId());
            $medicationHistoryDetailList[$key] = new MedicationHistoryDetail($item, $user, $drug);
        }

        return new MedicationHistoryDetailPaginator($medicationHistoryDetailList, $paginate);
    }

    public function createMedicationHistory(Id $userId, DrugName $drugName, MedicationHistoryAmount $amount): array
    {
        $drug = $this->drugDomainService->findDrugByName($drugName);
        $result = $this->medicationHistoryDomainService->create($userId, $drug->getId(), $amount);
        if (empty($result->toArray())) {
            return [
                'status' => false,
                'errors' => [
                    'key' => 'failed_create_medication_history',
                ],
                'data' => null,
            ];
        }

        return [
            'status' => true,
            'errors' => null,
            'data' => $result->toArray(),
        ];
    }

    /**
     * Update medication history
     *
     * @param MedicationHistory $medicationHistory
     * @return MedicationHistory
     */
    public function updateMedicationHistory(MedicationHistory $medicationHistory): MedicationHistory
    {
        return $this->medicationHistoryDomainService->update($medicationHistory);
    }

}
