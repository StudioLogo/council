<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouWereMentioned;
use App\User;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param ThreadReceivedNewReply $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        User::whereIn('name', $event->reply->mentionedUsers())
            ->get()
            ->each(fn ($user) => $user->notify(new YouWereMentioned($event->reply)));
//        collect($event->reply->mentionedUsers())
//            ->map(function ($name) {
//                return User::whereName($name)->first();
//            })
//            ->filter()
//            ->each(function ($user) use ($event) {
//                $user->notify(new YouWereMentioned($event->reply));
//            });

//        // Inspect the body of the reply for username mentions
//        $mentionedUsers = $event->reply->mentionedUsers();
//
//        // And then for each mentioned user, notify them.
//        foreach ($mentionedUsers as $name){
//            if(User::whereName($name)->first()){
//                User::whereName($name)->first()->notify(new YouWereMentioned($event->reply));
//            }
//        }
    }
}
