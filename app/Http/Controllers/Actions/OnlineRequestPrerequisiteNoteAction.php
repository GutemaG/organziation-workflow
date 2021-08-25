<?php


namespace App\Http\Controllers\Actions;


use App\Models\OnlineRequestPrerequisiteNote;

class OnlineRequestPrerequisiteNoteAction
{
    public static function store(array $data): void
    {
        OnlineRequestPrerequisiteNote::create($data);
    }

    public static function storeData(array $data, int $onlineRequestId): void
    {
        if (array_key_exists('prerequisites', $data)) {
            if (array_key_exists('notes', $data['prerequisites']))
                foreach ($data['prerequisites']['notes'] as $value) {
                    $temp = ['online_request_id' => $onlineRequestId, 'note' => $value];
                    self::store($temp);
                }
        }
    }
}
