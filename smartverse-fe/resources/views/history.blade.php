@extends('layouts.app')
@section('title', 'History - NeuroNote')

@push('styles')
    <style>
        body {
            background-color: #f5f5f5;
        }

        .history-wrapper {
            padding: 32px 0 50px;
        }

        .back-link {
            text-decoration: none;
            color: #6b7280;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
        }

        .back-link:hover {
            color: #3b82f6;
        }

        .history-title {
            font-size: 40px;
            font-weight: 700;
            color: #111827;
            line-height: 1;
            margin-bottom: 8px;
        }

        .history-subtitle {
            color: #6b7280;
            font-size: 17px;
            margin-bottom: 28px;
        }

        .search-filter-wrapper {
            background: white;
            border-radius: 10px;
            padding: 14px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 36px;
        }

        .filter-icon {
            width: 18px;
            height: 18px;
            object-fit: contain;
        }

        .dropdown-icon {
            width: 18px;
            height: 18px;
            object-fit: contain;
        }

        .custom-dropdown {
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 8px;
        }

        .custom-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
        }

        .custom-dropdown-item:hover {
            background: #eff6ff;
        }

        .search-box {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 22px;
            height: 22px;
            object-fit: contain;
            z-index: 2;
        }

        .search-box input {
            height: 48px;
            border-radius: 8px;
            padding-left: 45px;
            border: 1px solid #d1d5db;
        }

        .search-box i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 18px;
        }

        .filter-btn {
            background: #3b82f6;
            border: none;
            height: 48px;
            border-radius: 8px;
            padding: 0 18px;
            color: white;
            font-weight: 600;
        }

        .filter-btn:hover {
            background: #2563eb;
        }

        .dropdown-menu {
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 8px;
        }

        .dropdown-item {
            border-radius: 6px;
            padding: 10px 12px;
        }

        .dropdown-item:hover {
            background: #eff6ff;
        }

        .file-count {
            margin-bottom: 20px;
            font-size: 18px;
            color: #374151;
        }

        .history-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 18px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        }

        .file-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            background: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            flex-shrink: 0;
        }

        .file-icon img {
            width: 35px;
            height: 35px;
            overflow: contain;
        }

        .file-title {
            font-size: 22px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 2px;
        }

        .file-name {
            color: #6b7280;
            margin-bottom: 10px;
        }

        .generated-time {
            color: #4b5563;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .summary-btn {
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
            font-weight: 600;
            text-decoration: none;
        }

        .summary-btn:hover {
            background: #2563eb;
            color: white;
        }

        .delete-btn {
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-weight: 600;
        }

        .delete-btn:hover {
            background: #dc2626;
        }

        .summary-btn,
        .delete-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            line-height: 1;
        }

        .btn-icon {
            width: 18px;
            height: 18px;
            object-fit: contain;
            display: block;
            margin-right: 0;
        }

        .pagination-wrapper {
            margin-top: 40px;
        }

        .pagination .page-link {
            border: none;
            color: #374151;
            margin: 0 4px;
            border-radius: 8px;
        }

        .pagination .active .page-link {
            background: #3b82f6;
            color: white;
        }

        .custom-page-nav {
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
            padding: 6px 10px;
        }

        .custom-page-nav:hover {
            color: #3b82f6;
        }

        .custom-page-nav img {
            width: 14px;
            height: 14px;
            object-fit: contain;
        }
    </style>
@endpush

@section('content')
    <div class="container history-wrapper">
        <a href="/" class="text-decoration-none text-secondary fw-semibold back-link mb-4">
            <img src="{{ asset('images/back.png') }}" width="18" alt="Back">
            Back to Home
        </a>

        {{-- Title --}}
        <h1 class="history-title">History</h1>
        <p class="history-subtitle">
            Access all of the old files that had been processed here
        </p>

        {{-- Search & Filter --}}
        <div class="search-filter-wrapper">
            <div class="row g-3 align-items-center">
                <div class="col-lg-10">
                    <form method="GET" action="{{ url('/history') }}" class="d-flex gap-2">
                        <div class="search-box flex-grow-1">
                            <img src="{{ asset('images/Search.png') }}" alt="search icon" class="search-icon">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="search here based on file name or title...">
                        </div>

                        <select name="per_page" class="form-select" style="width:110px">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>

                        <button class="filter-btn" type="submit">Apply</button>
                    </form>
                </div>

                <div class="col-lg-2">
                    <div class="dropdown w-100">
                        <button class="filter-btn w-100 d-flex align-items-center justify-content-center gap-2"
                            type="button" data-bs-toggle="dropdown">
                            <img src="{{ asset('images/filter.png') }}" alt="filter" class="filter-icon">
                            <span>Filter</span>
                        </button>

                        <ul class="dropdown-menu w-100 custom-dropdown">
                            <li>
                                <a class="dropdown-item custom-dropdown-item" href="{{ request()->fullUrlWithQuery(['type' => 'all']) }}">
                                    <img src="{{ asset('images/filter_all.png') }}" alt="all" class="dropdown-icon"> All
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item custom-dropdown-item" href="{{ request()->fullUrlWithQuery(['type' => 'ppt']) }}">
                                    <img src="{{ asset('images/filter_ppt.png') }}" alt="ppt" class="dropdown-icon"> PPT
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item custom-dropdown-item" href="{{ request()->fullUrlWithQuery(['type' => 'video']) }}">
                                    <img src="{{ asset('images/filter_video.png') }}" alt="video" class="dropdown-icon"> Video
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- File Count & History Cards --}}
        @if ($summaries->isEmpty())
            <div class="empty-state">
                <p>No summary history yet. Start by uploading a file to create your first summary!</p>
            </div>
        @else
            <p class="file-count">
                Showing {{ $summaries->count() }} {{ $summaries->count() === 1 ? 'file' : 'files' }}
            </p>

            {{-- History Cards --}}
            @foreach ($summaries as $summary)
                <div class="history-card d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div class="d-flex gap-3">
                        <div class="file-icon">
                            @if (strpos($summary->file_type ?? '', 'video') !== false)
                                <img src="{{ asset('images/Video_2.png') }}" alt="">
                            @else
                                <img src="{{ asset('images/File_2.png') }}" alt="">
                            @endif
                        </div>

                        <div>
                            <div class="file-title">{{ $summary->topic ?? 'Summary' }}</div>
                            <div class="file-name">{{ $summary->file_name ?? 'Unknown file' }}</div>

                            <div class="generated-time">
                                <img src="{{ asset('images/Clock.png') }}" alt="" height="20" width="20">
                                Generated: {{ $summary->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 action-wrapper">
                        <a href="{{ url('/summary/'.$summary->id) }}" class="summary-btn">
                            <img src="{{ asset('images/eye_2.png') }}" alt="" class="btn-icon">
                            View Summary
                        </a>

                        <form action="{{ url('/summary/'.$summary->id) }}" method="POST" style="display:inline;" onsubmit="if (!confirm('Are you sure you want to delete this summary?')) return false; sessionStorage.removeItem('last_summary'); return true;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">
                                <img src="{{ asset('images/trash.png') }}" alt="" class="btn-icon">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

            {{-- Pagination (if available) --}}
            <div class="pagination-wrapper d-flex justify-content-center">
                @if (method_exists($summaries, 'links'))
                    {{ $summaries->links() }}
                @else
                    <nav>
                        <ul class="pagination align-items-center">
                            <li class="page-item">
                                <a class="custom-page-nav" href="#">
                                    <img src="{{ asset('images/arrow_left.png') }}" alt="Previous"> Previous
                                </a>
                            </li>

                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>

                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>

                            <li class="page-item">
                                <span class="page-link">...</span>
                            </li>

                            <li class="page-item">
                                <a class="page-link" href="#">4</a>
                            </li>

                            <li class="page-item">
                                <a class="page-link" href="#">5</a>
                            </li>

                            <li class="page-item">
                                <a class="custom-page-nav" href="#">
                                    Next <img src="{{ asset('images/arrow_right.png') }}" alt="Next">
                                </a>
                            </li>

                        </ul>
                    </nav>
                @endif
            </div>
        @endif

    </div>
@endsection