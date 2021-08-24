<?php


namespace App\Http\Controllers\Actions;


use App\Models\FrequentlyAskedQuestion;
use Illuminate\Http\JsonResponse;

class FrequentlyAskedQuestionAction
{
    use MyJsonResponse;

    public static function index(): JsonResponse
    {
        $faqs = FrequentlyAskedQuestion::orderBy('question', 'asc')->get()->toArray();
        return self::successResponse(['faqs' => $faqs]);
    }

    public static function store(array $data): JsonResponse
    {
        $faq = FrequentlyAskedQuestion::create($data);
        return self::successResponse(['faq' => $faq->toArray()]);
    }

    public static function show(FrequentlyAskedQuestion $frequentlyAskedQuestion): JsonResponse
    {
        return self::successResponse(['faq' => $frequentlyAskedQuestion->toArray()]);
    }

    public static function update(FrequentlyAskedQuestion $frequentlyAskedQuestion, array $data): JsonResponse
    {
        $frequentlyAskedQuestion->update($data);
        return self::successResponse(['faq' => $frequentlyAskedQuestion->refresh()->toArray()]);
    }

    public static function destroy(FrequentlyAskedQuestion $frequentlyAskedQuestion): JsonResponse
    {
        $frequentlyAskedQuestion->delete();
        return self::successResponse();
    }
}
