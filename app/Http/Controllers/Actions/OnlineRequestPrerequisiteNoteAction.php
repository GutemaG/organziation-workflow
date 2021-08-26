<?php


namespace App\Http\Controllers\Actions;


use App\Models\OnlineRequest;
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

    public static function update(array $data): void
    {
        foreach ($data as $value) {
            $procedure = OnlineRequestPrerequisiteNote::find($value['id']);
            $procedure->update($value);
        }
    }

    public static function updateData(array $data, int $onlineRequestId): void
    {
        if (array_key_exists('prerequisites', $data)) {
            if (array_key_exists('notes', $data['prerequisites'])) {
                list($updatable, $creatable) = self::getUpdatableAndCreatableData($data['prerequisites']['notes']);
                $onlineRequest = OnlineRequest::with(['onlineRequestPrerequisiteNotes'])->find($onlineRequestId);
                self::deleteUnexistData($onlineRequest, $updatable);
                self::storeData(['prerequisites' => ['notes' => $creatable]], $onlineRequestId);
                self::update($updatable);
                return;
            }
        }
        $onlineRequest = OnlineRequest::with(['onlineRequestPrerequisiteNotes'])->find($onlineRequestId);
        self::deleteUnexistData($onlineRequest, []);
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
                    $creatable[] = $value['note'];

            });
        return array($updatable, $creatable);
    }

    /**
     * @param $onlineRequest
     * @param array $updatable
     */
    private static function deleteUnexistData($onlineRequest, array $updatable): void
    {
        $newId = [];
        $oldId = [];
        foreach ($onlineRequest->onlineRequestPrerequisiteNotes as $input)
            $oldId[] = $input->id;
        foreach ($updatable as $value)
            $newId[] = $value['id'];
        foreach ($oldId as $id)
            if (!in_array($id, $newId))
                OnlineRequestPrerequisiteNote::find($id)->delete();
    }
}
