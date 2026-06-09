<?php

namespace App\Http\Controllers;

use App\Services\SummarizerServices;
use App\Models\Summary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SummarizerController extends Controller
{
    protected SummarizerServices $_service;

    public function __construct(SummarizerServices $service)
    {
        $this->_service = $service;
    }

    public function index(Request $request)
    {
        set_time_limit(300);

        $file = $request->file('file');

        $result = $this->_service->executeSummary($file);

        return response()->json($result);
    }

    public function summary()
    {
        return view("summary");
    }

    public function history()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user) {
            $summaries = collect();
            return view('history', compact('summaries'));
        }

        $q       = request()->query('q');
        $perPage = max(1, min((int) request()->query('per_page', 10), 100));
        $type    = request()->query('type', 'all');

        $query = $user->summaries()->latest();

        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('file_name', 'like', "%{$q}%")
                        ->orWhere('topic', 'like', "%{$q}%");
            });
        }

        if ($type && $type !== 'all') {
            if ($type === 'video') {
                $query->where('file_type', 'like', '%video%');
            } elseif ($type === 'ppt') {
                $query->where(function ($b) {
                    $b->where('file_name', 'like', '%.ppt')
                      ->orWhere('file_name', 'like', '%.pptx')
                      ->orWhere('file_name', 'like', '%.pptm');
                });
            }
        }

        $summaries = $query->paginate($perPage)->withQueryString();

        return view('history', compact('summaries'));
    }

    public function show($id)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $summary = Summary::where('id', $id)
                          ->where('user_id', $user?->id)
                          ->firstOrFail();

        return view('summary', compact('summary'));
    }

    public function destroy($id)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        Summary::where('id', $id)
            ->where('user_id', $user?->id)
            ->delete();

        return redirect()->route('history')->with('status', 'Summary deleted successfully.');
    }
}