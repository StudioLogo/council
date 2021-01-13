@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} favorited a reply on the thread
        <a href="{{ $activity->subject->favorited->path()}}">"{{ $activity->subject->favorited->thread->title }}"</a>
{{--        <a href="{{ $activity->subject->thread->path()}}">"{{ $activity->subject->thread->title}}"</a>--}}
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent
