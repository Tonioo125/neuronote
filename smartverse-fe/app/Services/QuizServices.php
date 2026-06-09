<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class QuizServices
{
    public function generateQuiz(UploadedFile $file): array
    {
        $baseUrl = config('services.ai_summarizer.base_url');
        $response = Http::timeout(300)->attach(
            'file', $file->get(), $file->getClientOriginalName()
        )->post($baseUrl . '/generate-quiz');

        return $response->json() ?? [];
    }

    public function generateQuizFromText(string $text): array
    {
        $baseUrl = config('services.ai_summarizer.base_url');
        $response = Http::timeout(300)->asForm()->post($baseUrl . '/generate-quiz-from-text', [
            'text' => $text,
        ]);

        return $response->json() ?? [];
    }

    public function normalizeQuestions(array $quiz): array
    {
        $normalizedQuestions = [];

        if (!isset($quiz['questions'])) {
            return [];
        }

        foreach ($quiz['questions'] as $index => $q) {

            $normalizedQuestions[] = [
                'title' => 'Question ' . ($index + 1),

                'text' => $q['question'] ?? '',

                'name' => 'q' . ($index + 1),

                'options' => $q['options'] ?? [],

                'answer' => $q['answer'] ?? ''
            ];
        }

        return $normalizedQuestions;
    }


}