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
            <img src="{{ asset('images/back.png') }}" width="18">
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
                    <div class="search-box">
                        <img src="images/Search.png" alt="search icon" class="search-icon">
                        <input type="text" class="form-control" placeholder="search here based on file name or title...">
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="dropdown w-100">
                        <button class="filter-btn w-100 d-flex align-items-center justify-content-center gap-2"
                            type="button" data-bs-toggle="dropdown">
                            <img src="images/filter.png" alt="filter" class="filter-icon">
                            <span>Filter</span>
                        </button>

                        <ul class="dropdown-menu w-100 custom-dropdown">
                            <li>
                                <a class="dropdown-item custom-dropdown-item" href="#">
                                    <img src="images/filter_all.png" alt="all" class="dropdown-icon"> All
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item custom-dropdown-item" href="#">
                                    <img src="images/filter_ppt.png" alt="ppt" class="dropdown-icon"> PPT
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item custom-dropdown-item" href="#">
                                    <img src="images/filter_video.png" alt="video" class="dropdown-icon"> Video
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- File Count --}}
        <p class="file-count">
            Showing 5 out of 24 files
        </p>

        {{-- Card 1 --}}
        <div class="history-card d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div class="d-flex gap-3">
                <div class="file-icon">
                    <img src="images/File_2.png" alt="">
                </div>

                <div>
                    <div class="file-title">Lorem Ipsum Dolor Sit Amet</div>
                    <div class="file-name">Example.pptx</div>

                    <div class="generated-time">
                        <img src="images/Clock.png" alt="" height="20" width="20">
                        Generated: Recently
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 action-wrapper">
                <a href="#" class="summary-btn">
                    <img src="images/eye_2.png" alt="" class="btn-icon">
                    View Summary
                </a>

                <button class="delete-btn">
                    <img src="images/trash.png" alt="" class="btn-icon">
                    Delete
                </button>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="history-card d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div class="d-flex gap-3">
                <div class="file-icon">
                    <img src="images/File_2.png" alt="">
                </div>

                <div>
                    <div class="file-title">Lorem Ipsum Dolor Sit Amet 2</div>
                    <div class="file-name">Example2.ppt</div>

                    <div class="generated-time">
                        <img src="images/Clock.png" alt="" height="20" width="20">
                        Generated: 5 hours ago
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 action-wrapper">
                <a href="#" class="summary-btn">
                    <img src="images/eye_2.png" alt="" class="btn-icon">
                    View Summary
                </a>

                <button class="delete-btn">
                    <img src="images/trash.png" alt="" class="btn-icon">
                    Delete
                </button>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="history-card d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div class="d-flex gap-3">
                <div class="file-icon">
                    <img src="images/Video_2.png" alt="">
                </div>

                <div>
                    <div class="file-title">Lorem Ipsum Dolor Sit Amet 3</div>
                    <div class="file-name">Example3.mp4</div>

                    <div class="generated-time">
                        <img src="images/Clock.png" alt="" height="20" width="20">
                        Generated: 3 days ago
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 action-wrapper">
                <a href="#" class="summary-btn">
                    <img src="images/eye_2.png" alt="" class="btn-icon">
                    View Summary
                </a>

                <button class="delete-btn">
                    <img src="images/trash.png" alt="" class="btn-icon">
                    Delete
                </button>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="history-card d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div class="d-flex gap-3">
                <div class="file-icon">
                    <img src="images/Video_2.png" alt="">
                </div>

                <div>
                    <div class="file-title">Lorem Ipsum Dolor Sit Amet 4</div>
                    <div class="file-name">Example4.mov</div>

                    <div class="generated-time">
                        <img src="images/Clock.png" alt="" height="20" width="20">
                        Generated: 2 weeks ago
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 action-wrapper">
                <a href="#" class="summary-btn">
                    <img src="images/eye_2.png" alt="" class="btn-icon">
                    View Summary
                </a>

                <button class="delete-btn">
                    <img src="images/trash.png" alt="" class="btn-icon">
                    Delete
                </button>
            </div>
        </div>

        {{-- Card 5 --}}
        <div class="history-card d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div class="d-flex gap-3">
                <div class="file-icon">
                    <img src="images/Video_2.png" alt="">
                </div>

                <div>
                    <div class="file-title">Lorem Ipsum Dolor Sit Amet 5</div>
                    <div class="file-name">Example5.avi</div>

                    <div class="generated-time">
                        <img src="images/Clock.png" alt="" height="20" width="20">
                        Generated: 1 month ago
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 action-wrapper">
                <a href="#" class="summary-btn">
                    <img src="images/eye_2.png" alt="" class="btn-icon">
                    View Summary
                </a>

                <button class="delete-btn">
                    <img src="images/trash.png" alt="" class="btn-icon">
                    Delete
                </button>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrapper d-flex justify-content-center">
            <nav>
                <ul class="pagination align-items-center">

                    <li class="page-item">
                        <a class="custom-page-nav" href="#">
                            <img src="images/arrow_left.png" alt="Previous"> Previous
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
                            Next <img src="images/arrow_right.png" alt="Next">
                        </a>
                    </li>

                </ul>
            </nav>
        </div>

    </div>
@endsection
