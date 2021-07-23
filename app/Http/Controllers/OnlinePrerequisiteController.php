<?php

namespace App\Http\Controllers;

use App\Models\PrerequisiteLabel;
use Exception;
use Illuminate\Http\Request;

class OnlinePrerequisiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage if the data is exist.
     *
     * @param $data
     * @param $onlineRequestId
     * @return bool
     */
    public static function store($data, $onlineRequestId): bool
    {
        if (array_key_exists('prerequisite_labels', $data)) {
            $labels = collect($data['prerequisite_labels'])
                ->map(function ($value, $key) use ($onlineRequestId) {
                    return ['label' => $value, 'online_request_id' => $onlineRequestId];
                });
            try {
                PrerequisiteLabel::insert($labels->toArray());
                return true;
            }
            catch (Exception $e) {
                return false;
            }
        }
        return  false;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PrerequisiteLabel  $prerequisiteLabel
     * @return \Illuminate\Http\Response
     */
    public function show(PrerequisiteLabel $prerequisiteLabel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PrerequisiteLabel  $prerequisiteLabel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PrerequisiteLabel $prerequisiteLabel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PrerequisiteLabel  $prerequisiteLabel
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrerequisiteLabel $prerequisiteLabel)
    {
        //
    }
}
