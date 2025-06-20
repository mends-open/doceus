@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')

@section('message')
    {{ __('Not Found') }}
    <div style="margin-top: 1rem;">
        <a href="{{ url('/') }}">{{ __('Home') }}</a>
        @auth
            <form method="POST" action="{{ route('filament.app.auth.logout') }}" style="display: inline; margin-left: 0.5rem;">
                @csrf
                <button type="submit">{{ __('Logout') }}</button>
            </form>
        @else
            <a href="{{ route('filament.app.auth.login') }}" style="margin-left: 0.5rem;">{{ __('Login') }}</a>
        @endauth
    </div>
@endsection
