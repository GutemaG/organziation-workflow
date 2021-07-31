<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Actions\OnlinePrerequisiteAction;
use App\Http\Requests\OnlinePrerequisiteRequest;
use App\Models\PrerequisiteLabel;
use Exception;
use Illuminate\Http\JsonResponse;

class OnlinePrerequisiteController extends Controller
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
     * @param OnlinePrerequisiteRequest $request
     * @param PrerequisiteLabel $prerequisiteLabel
     * @return bool
     */
    public static function update(OnlinePrerequisiteRequest $request, PrerequisiteLabel $prerequisiteLabel): JsonResponse
    {
        $prerequisiteLabel->update($request->validated());
        return response()->json([
           'status' => 200,
           'prerequisite' => $prerequisiteLabel->refresh(),
        ]);
    }

    /**
     * Categorize each value of incoming data to updatable and creatable.
     * So that the new Prerequisite added will be stored and the existing prerequisite will be updated.
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
     * And also during updating it will identify the existing and new prerequisite,
     * so that it will update the existing prerequisite and store the new prerequisite.
     *
     * @param array $data
     * @param int $onlineRequestId
     * @param bool $update
     * @return bool
     */
    public static function storeOrUpdateData(array $data, int $onlineRequestId, bool $update=false): bool
    {
        if ($update) {
            if (array_key_exists('prerequisite_labels', $data)) {
                list($updatableData, $creatableData) = self::getUpdatableAndCreatableData($data['prerequisite_labels']);
                $creatableData = self::prepareForStoring($creatableData, $onlineRequestId);
                if (! OnlinePrerequisiteAction::update($updatableData) || ! self::store($creatableData))
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
     * Prepare the incoming prerequisite data by adding the online_request_id to it,
     * so that it can be stored properly.
     *
     * @param array $creatableData
     * @param int $onlineRequestId
     * @return array
     */
    protected static function prepareForStoring(array $creatableData, int $onlineRequestId): array
    {
        return collect($creatableData)->map(function ($value) use ($onlineRequestId) {
            if (is_array($value)) {
                $value['online_request_id'] = $onlineRequestId;
                return $value;
            }
            return ['label' => $value, 'online_request_id' => $onlineRequestId];
        })->toArray();
    }

}
