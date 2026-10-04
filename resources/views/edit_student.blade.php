@extends('layouts.app')

@section('title', 'Edit Student — Student Information System')

@section('header_title')
    <div class="topbar-breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <span>Edit Student</span>
    </div>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-error">
            ⚠️ Please fix the following errors:
            <ul style="margin-top: 8px; margin-left: 24px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <div class="form-card-header">
            <span class="form-card-title">Edit Student Record</span>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Back</a>
        </div>

        <div class="form-card-body">
            <form action="{{ route('students.update', $student->student_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" name="first_name" id="firstName"
                               class="form-control" value="{{ old('first_name', $student->first_name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" name="last_name" id="lastName"
                               class="form-control" value="{{ old('last_name', $student->last_name) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="emailAddress">Email Address</label>
                    <input type="email" name="email" id="emailAddress"
                           class="form-control" value="{{ old('email', $student->email) }}" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="yearLevel">Year Level</label>
                        <select name="year_level" id="yearLevel" class="form-control" required>
                            <option value="">Select Year</option>
                            <option value="1" {{ old('year_level', $student->year_level) == '1' ? 'selected' : '' }}>1st Year</option>
                            <option value="2" {{ old('year_level', $student->year_level) == '2' ? 'selected' : '' }}>2nd Year</option>
                            <option value="3" {{ old('year_level', $student->year_level) == '3' ? 'selected' : '' }}>3rd Year</option>
                            <option value="4" {{ old('year_level', $student->year_level) == '4' ? 'selected' : '' }}>4th Year</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="courseId">Course / Program</label>
                        <select name="course_id" id="courseId" class="form-control" required>
                            <option value="">Select Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->course_id }}" {{ old('course_id', $student->course_id) == $course->course_id ? 'selected' : '' }}>
                                    {{ $course->course_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Record</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>
@endsection