<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Actions\FrequentlyAskedQuestionAction;
use App\Http\Requests\FAQRequest;
use App\Models\FrequentlyAskedQuestion;
use Illuminate\Http\JsonResponse;

class FrequentlyAskedQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        return FrequentlyAskedQuestionAction::index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FAQRequest $request): JsonResponse
    {
        $data = $request->validated();
        return FrequentlyAskedQuestionAction::store($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FrequentlyAskedQuestion  $frequentlyAskedQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(FrequentlyAskedQuestion $frequentlyAskedQuestion): JsonResponse
    {
        return FrequentlyAskedQuestionAction::show($frequentlyAskedQuestion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FrequentlyAskedQuestion  $frequentlyAskedQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(FAQRequest $request, FrequentlyAskedQuestion $frequentlyAskedQuestion): JsonResponse
    {
        $data = $request->validated();
        return FrequentlyAskedQuestionAction::update($frequentlyAskedQuestion, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FrequentlyAskedQuestion  $frequentlyAskedQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(FrequentlyAskedQuestion $frequentlyAskedQuestion): JsonResponse
    {
        return FrequentlyAskedQuestionAction::destroy($frequentlyAskedQuestion);
    }
}
