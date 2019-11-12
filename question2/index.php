<?php
function getStatistics() {
        $data = [];
        $data['users'] = [];
        // 65k rows
        $allTptp = TariffProviderTariffMatch::all();
        foreach ($allTptp as $each) {
            if (!array_key_exists($each->user_id, $data['users'])){
                $one = [];
                $one['name'] = $each->first_name . " " . $each->last_name;
                $one['valid'] = 0;
                $one['pending'] = 0;
                $one['invalid'] = 0;
                $one['total'] = 0;
                $one['cash'] = 0;
                $data['users'][$each->user_id] = $one;
            }
            
            switch ($each->active_status) {
                case ActiveStatus::ACTIVE: // 1
                    $data['users'][$each->user_id]['valid']++;
                    $data['users'][$each->user_id]['cash'] += floatval(GlobalVariable::getById(GlobalVariable::STANDARDIZATION_UNIT_PRICE)->value);
                    break;
                case ActiveStatus::PENDING: // 2
                    $data['users'][$each->user_id]['pending']++;
                    break;
                case ActiveStatus::DELETED: // 3
                    $data['users'][$each->user_id]['invalid']++;
                    break;
            }
            $data['users'][$each->user_id]['total']++;
            $data['users'][$each->user_id]['cash'] = number_format($data['users'][$each->user_id]['cash'],2);
        }
        return $data;
}
?>