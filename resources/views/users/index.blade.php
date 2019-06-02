
@extends('layouts.default')
@section('title', '所有用户')

@section('content')
    <div class="offset-md-2 col-md-8">
        <h2 class="mb-4 text-center">所有用户</h2>
        <div class="list-group list-group-flush">
            @foreach ($users as $user)
                <div class="list-group-item">
                    <img class="mr-3" src="" alt="{{ $user->name }}" width=32>
                    <a href="{{ route('users.show', $user) }}">
                        {{ $user->name }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Page -->
    <div class="mt-3">
        {!! $users->render() !!}
    </div>
@endsection('content')