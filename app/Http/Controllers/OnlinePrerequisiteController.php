<?php

namespace App\Http\Controllers;

use App\Models\PrerequisiteLabel;
use Exception;

class OnlinePrerequisiteController extends Controller
{

    /**
     * Store a newly created resource in storage if the data is exist.
     *
     * @param $data
     * @param int $onlineRequestId
     * @param bool $storeOnly
     * @return bool
     */
    public static function store($data): bool
    {
        try {
            PrerequisiteLabel::insert($data);
            return true;
        }
        catch (Exception $e) {
            return false;
        }
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
                $prerequisite = PrerequisiteLabel::find($value['id']);
                $prerequisite->update($value);
            }
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $prerequisite_labels
     * @return array[]
     */
    protected static function getUpdatableAndCreatableData($prerequisite_labels): array
    {
        $updatable = [];
        $creatable = [];

        collect($prerequisite_labels)
            ->filter(function ($value, $key) use (&$updatable, &$creatable) {
                array_key_exists('id', $value) ?
                    $updatable[] = $value :
                    $creatable[] = $value;

            });
        return array($updatable, $creatable);
    }

    public static function storeOrUpdateData(array $data, int $onlineRequestId, bool $update=false): bool
    {
        if ($update) {
            if (array_key_exists('prerequisite_labels', $data)) {
                list($updatableData, $creatableData) = self::getUpdatableAndCreatableData($data['prerequisite_labels']);
                $creatableData = self::prepareForStoring($creatableData, $onlineRequestId);
                if (! self::update($updatableData) || ! self::store($creatableData))
                    return false;
            }
            return true;
        }
        else {
            if (array_key_exists('prerequisite_labels', $data)) {
                $creatableData = self::prepareForStoring($data['prerequisite_labels'], $onlineRequestId);
                if (!self::store($creatableData))
                    return false;
            }
            return true;
        }
    }

    /**
     * @param array $creatableData
     * @param int $onlineRequestId
     * @return array
     */
    protected static function prepareForStoring(array $creatableData, int $onlineRequestId): array
    {
        return collect($creatableData)->map(function ($value, $key) use ($onlineRequestId) {
            if (is_array($value)) {
                $value['online_request_id'] = $onlineRequestId;
                return $value;
            }
            return ['label' => $value, 'online_request_id' => $onlineRequestId];
        })->toArray();
    }

}
