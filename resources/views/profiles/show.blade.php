@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">
                    <avatar-form :user="{{ $profileUser }}"></avatar-form>
                </div>

                @forelse($activities as $date => $dateActivities)
                    <h3 class="page-header">{{ $date }}</h3>

                    @foreach($dateActivities as $activity)
                        @if(view()->exists("profiles.activities.{$activity->type}"))
                            @include("profiles.activities.{$activity->type}")
                        @endif
                    @endforeach
                @empty
                    <p>There is not activity for this user yet.</p>
                @endforelse

            </div>
        </div>
    </div>

@endsection
