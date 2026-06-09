<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SummarizerServices
{
    public function executeSummaryFromUrl(string $fileUrl, string $fileName, string $mimeType): array
    {
        if (str_contains($mimeType, 'video')) {
            return $this->summarizeUrl($fileUrl, $fileName, '/summarize-video-from-url');
        }

        if (str_contains($mimeType, 'pdf') || str_contains($mimeType, 'presentation') || str_contains($mimeType, 'powerpoint')) {
            return $this->summarizeUrl($fileUrl, $fileName, '/summarize-from-url');
        }

        return ['status' => 'error', 'message' => 'Format file tidak didukung.'];
    }

    private function summarizeUrl(string $fileUrl, string $fileName, string $endpoint): array
    {
        $url = config('services.ai_summarizer.base_url') . $endpoint;

        $response = Http::timeout(300)->asForm()->post($url, [
            'file_url'  => $fileUrl,
            'file_name' => $fileName,
        ]);

        return $response->json() ?? ['status' => 'error', 'message' => 'No response from AI service.'];
    }
}