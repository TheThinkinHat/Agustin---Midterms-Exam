<x-guest-layout title="Admin Login">
    @if ($errors->any())
        <div class="alert alert-error" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="student-form">
        @csrf

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required autofocus autocomplete="username">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password">
        </div>

        <button type="submit" class="btn btn-primary btn-submit">Login</button>
    </form>

    <div class="auth-switch-link">
        <p>Don't have an account? <a href="{{ route('register') }}">Register here</a>.</p>
    </div>
</x-guest-layout>
