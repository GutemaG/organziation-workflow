<?php

namespace App\Http\Controllers;

use App\Models\OnlineRequestProcedure;
use Exception;

class OnlineRequestProcedureController extends Controller
{
    /**
    * Store a newly created resource in storage.
    *
    * @param $data
    * @return bool
    */
    public static function store($data): bool
    {
        try {
            foreach ($data as $value) {
                $procedure = OnlineRequestProcedure::create($value);
                self::attach($value['responsible_user_id'], $procedure, false);
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
     * @param bool $update
     * @return bool
     */
    private static function attach(array $data, OnlineRequestProcedure $procedure, bool $update=false): bool
    {
        if ($update) {
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
        else{
            try {
                $procedure->users()->attach($data);
                return true;
            }
            catch (Exception $e) {
                return false;
            }
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
                self::attach($value['responsible_user_id'], $procedure, true);
            }
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * Categorize each value of incoming data to updatable and creatable.
     * So that the new procedure added will be stored and the existing procedure will be updated.
     *
     * @param $prerequisite_labels
     * @return array[]
     */
    protected static function getUpdatableAndCreatableData($prerequisite_labels): array
    {
        $updatable = [];
        $creatable = [];

        collect($prerequisite_labels)
            ->filter(function ($value) use (&$updatable, &$creatable) {
                array_key_exists('id', $value) ?
                    $updatable[] = $value :
                    $creatable[] = $value;

            });
        return array($updatable, $creatable);
    }

    /**
     * Decide the incoming data should be updated or stored.
     * And also during updating it will identify the existing and new procedure,
     * so that it will update the existing procedure and store the new procedure.
     *
     * @param array $data
     * @param int $onlineRequestId
     * @param bool $update
     * @return bool
     */
    public static function storeOrUpdateData(array $data, int $onlineRequestId, bool $update=false): bool
    {
        if ($update) {
            list($updatableData, $creatableData) = self::getUpdatableAndCreatableData($data['online_request_procedures']);
            $creatableData = self::prepareForStoring($creatableData, $onlineRequestId);
            if (! self::update($updatableData) || ! self::store($creatableData))
                return false;
            return true;
        }
        else {
            $creatableData = self::prepareForStoring($data['online_request_procedures'], $onlineRequestId);
            if (!self::store($creatableData))
                return false;
            return true;
        }
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
}
