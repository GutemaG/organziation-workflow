<?php


namespace App\Http\Controllers\Actions;

use App\Models\OnlineRequestProcedure;
use Exception;

class OnlineRequestProcedureAction
{
    public static function store(array $data): void
    {
        $procedure = OnlineRequestProcedure::create($data);
        self::attach($data['responsible_user_id'], $procedure, false);
    }

    public static function storeData(array $data, int $onlineRequestId): void
    {
        $creatableData = self::prepareForStoring($data['online_request_procedures'], $onlineRequestId);
        foreach ($creatableData as $value)
            self::store($value);
    }

    /**
     * Prepare the incoming procedure data by adding the online_request_id to it,
     * so that it can be stored properly.
     * And also sort the procedures using step number in acceding order.
     *
     * @param array $creatableData
     * @param int $onlineRequestId
     * @return array
     */
    protected static function prepareForStoring(array $creatableData, int $onlineRequestId): array
    {
        return collect($creatableData)->map(function ($value) use ($onlineRequestId) {
            $value['online_request_id'] = $onlineRequestId;
            return $value;
        })->sortBy('step_number')->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param array $data
     * @return bool
     */
    public static function update(array $data): bool
    {
        try {
            foreach ($data as $value) {
                $procedure = OnlineRequestProcedure::find($value['id']);
                $procedure->update($value);
                self::attach($value['responsible_user_id'], $procedure);
            }
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * Attach online request procedure with user both for store and update;
     *
     * @param array $data
     * @param OnlineRequestProcedure $procedure
     * @return bool
     */
    private static function attach(array $data, OnlineRequestProcedure $procedure, bool $update=false): bool
    {
        list($oldUserId, $newUserId) = self::getAttachedAndDetachedData($procedure, $data);
        try {
            $procedure->users()->detach($oldUserId);
            $procedure->users()->attach($newUserId);
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get attached and detached user id for update procedure.
     *
     * @param OnlineRequestProcedure $procedure
     * @param array $data
     * @return array[]
     */
    private static function getAttachedAndDetachedData(OnlineRequestProcedure $procedure, array $data): array
    {
        $currentlyExistedUserId = [];
        $oldUserId = [];
        $newUserId = [];
        foreach ($procedure->users as $user)
            in_array($user->id, $data) ? $currentlyExistedUserId[] = $user->id : $oldUserId[] = $user->id;
        foreach ($data as $value)
            in_array($value, $currentlyExistedUserId) ? null : $newUserId[] = $value;
        return array($oldUserId, $newUserId);
    }


}
