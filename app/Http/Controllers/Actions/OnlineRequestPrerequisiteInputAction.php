<?php


namespace App\Http\Controllers\Actions;


use App\Models\OnlineRequestPrerequisiteInput;

class OnlineRequestPrerequisiteInputAction
{
    public static function store(array $data): void
    {
        OnlineRequestPrerequisiteInput::create($data);
    }

    public static function storeData(array $data, int $onlineRequestId): void
    {
        if (array_key_exists('prerequisites', $data)) {
            if (array_key_exists('inputs', $data['prerequisites']))
                foreach ($data['prerequisites']['inputs'] as $value) {
                    $temp = [
                        'online_request_id' => $onlineRequestId,
                        'name' => $value['name'],
                        'input_id' => $value['input_id'],
                        'type' => $value['type'],
                    ];
                    self::store($temp);
                }
        }
    }
}
