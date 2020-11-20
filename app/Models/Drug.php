<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Model as AppModel;

class Drug extends AppModel
{

    protected $table = 'drugs';

    protected $fillable = [
        'drug_name',
        'url'
    ];

    public function MedicationHistory() {

        return $this->hasMany('App\Model\MedicationHistory', 'drug_id');

    }

}