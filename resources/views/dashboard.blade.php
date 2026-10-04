@extends('layouts.app')

@section('title', 'Student Records — Student Information System')

@section('header_title', 'Student Records')

@section('topbar_actions')
    <a href="{{ route('students.create') }}" class="btn btn-primary">+ Add Student</a>
@endsection

@section('content')
    <div class="stats-row">
        <div class="stat-card accent">
            <div class="stat-label">Students shown</div>
            <div class="stat-num">{{ $total_students }}</div>
            <div class="stat-sub">Matching current filters</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">1st year</div>
            <div class="stat-num">{{ $count_y1 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">2nd year</div>
            <div class="stat-num">{{ $count_y2 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">3rd and 4th year</div>
            <div class="stat-num">{{ $count_y3y4 }}</div>
        </div>
    </div>

    <section class="table-card" aria-labelledby="records-heading">
        <div class="table-toolbar">
            <div class="table-toolbar-left">
                <h2 class="table-section-title" id="records-heading">Student directory</h2>
            </div>
            <form action="{{ route('dashboard') }}" method="GET" class="search-form" role="search">
                <label class="search-wrap">
                    <span class="search-icon" aria-hidden="true">⌕</span>
                    <span class="sr-only">Search students</span>
                    <input type="search" name="search" class="search-input" value="{{ $search }}" placeholder="Name, email, or course">
                </label>
                <button type="submit" class="btn btn-secondary">Search</button>
                @if ($search !== '')
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Clear</a>
                @endif
            </form>
        </div>

        <div class="table-wrapper">
            <table class="student-table">
                <thead>
                    <tr>
                        <th scope="col">Student</th>
                        <th scope="col">Email</th>
                        <th scope="col">Year</th>
                        <th scope="col">Course</th>
                        <th scope="col"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td class="td-name">{{ $student->last_name }}, {{ $student->first_name }}</td>
                            <td class="td-email">{{ $student->email }}</td>
                            <td><span class="year-badge y{{ $student->year_level }}">{{ $student->year_level }}{{ (int) $student->year_level === 1 ? 'st' : ((int) $student->year_level === 2 ? 'nd' : ((int) $student->year_level === 3 ? 'rd' : 'th')) }} year</span></td>
                            <td>{{ $student->course?->course_name ?? 'Unassigned' }}</td>
                            <td>
                                <div class="action-links">
                                    <a href="{{ route('students.edit', $student->student_id) }}" class="action-btn edit">Edit</a>
                                    <form action="{{ route('students.destroy', $student->student_id) }}" method="POST" onsubmit="return confirm('Delete this student record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <h3>No student records found</h3>
                                    <p>{{ $search ? 'Try a different search term.' : 'Add a student to get started.' }}</p>
                                    @unless ($search)
                                        <a href="{{ route('students.create') }}" class="btn btn-primary">+ Add Student</a>
                                    @endunless
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
