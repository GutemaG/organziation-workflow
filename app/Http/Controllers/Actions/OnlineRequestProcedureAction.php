<?php


namespace App\Http\Controllers\Actions;

use App\Models\OnlineRequestProcedure;
use Exception;

class OnlineRequestProcedureAction
{
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
    private static function attach(array $data, OnlineRequestProcedure $procedure): bool
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
