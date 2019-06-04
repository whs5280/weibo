
@extends('layouts.default')
@section('title', $user->name)

@section('content')
    <div class="row">
        <div class="offset-md-2 col-md-8">
            <section class="user_info">
                @include('shared.user_info', ['user' => $user])
            </section>

            @if (Auth::check())
                @include('users.follow_form')
            @endif

            <section class="stats mt-2">
                @include('shared.stats', ['user' => $user])
            </section>
            <section class="status">
                @if($statuses->count() > 0)
                    <ul class="list-unstyled">
                        @foreach($statuses as $status)
                            @include('statuses.status')
                        @endforeach
                    </ul>

                    <div class="mt-5">
                        {!! $statuses->render() !!}
                    </div>
                @else
                    <p>没有动态！</p>
                @endif
            </section>
        </div>
    </div>
@stop