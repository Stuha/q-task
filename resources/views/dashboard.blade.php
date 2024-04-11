
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Welcome to Your Dashboard</h2>
                    <p class="card-text">Profile Information:</p>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Name:</strong> {{ $user->first_name }}</li>
                        <li class="list-group-item"><strong>Surname:</strong> {{ $user->last_name }} <li>
                    </ul>
                    <a href="{{ route('logout') }}" class="btn btn-danger mt-3">Logout</a>
                </div>
            </div>
        </div>
    </div>
    @error('error')
    <div class="alert alert-danger">
        {{ $message }}
    </div>
    @endif
</div>
@endsection
