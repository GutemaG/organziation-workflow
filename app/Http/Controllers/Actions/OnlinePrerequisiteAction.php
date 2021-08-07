<?php


namespace App\Http\Controllers\Actions;


use App\Models\PrerequisiteLabel;
use Exception;

class OnlinePrerequisiteAction
{
    public static function update(array $data): bool
    {
        try {
            foreach ($data as $value) {
                $prerequisite = PrerequisiteLabel::find($value['id']);
                $prerequisite->update($value);
            }
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }
}
