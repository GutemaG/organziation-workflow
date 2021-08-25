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

    public static function update(array $data): void
    {
        foreach ($data as $value) {
            $procedure = OnlineRequestPrerequisiteInput::find($value['id']);
            $procedure->update($value);
        }
    }

    public static function updateData(array $data, int $onlineRequestId): void
    {
        if (array_key_exists('prerequisites', $data))
            if (array_key_exists('inputs', $data['prerequisites'])) {
                list($updatable, $creatable) = self::getUpdatableAndCreatableData($data['prerequisites']['inputs']);
                self::storeData(['prerequisites'=>['inputs' => $creatable]], $onlineRequestId);
                self::update($updatable);
            }
    }

    /**
     * Categorize each value of incoming data to updatable and creatable.
     * So that the new procedure added will be stored and the existing procedure will be updated.
     *
     * @param $data
     * @return array[]
     */
    protected static function getUpdatableAndCreatableData(array $data): array
    {
        $updatable = [];
        $creatable = [];

        collect($data)
            ->filter(function ($value) use (&$updatable, &$creatable) {
                array_key_exists('id', $value) ?
                    $updatable[] = $value :
                    $creatable[] = $value;

            });
        return array($updatable, $creatable);
    }
}
