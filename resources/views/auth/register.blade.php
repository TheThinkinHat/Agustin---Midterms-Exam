<x-guest-layout title="Register Admin">
    @if ($errors->any())
        <div class="alert alert-error" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="student-form">
        @csrf

        <div class="form-group">
            <label for="username">Choose a Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required autofocus autocomplete="username">
        </div>

        <div class="form-group">
            <label for="password">Choose a Password</label>
            <input type="password" name="password" id="password" class="form-control" required autocomplete="new-password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-warning btn-submit">Create Account</button>
    </form>

    <div class="auth-switch-link">
        <p>Already registered? <a href="{{ route('login') }}">Login here</a>.</p>
    </div>
</x-guest-layout>
