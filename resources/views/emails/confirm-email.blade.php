@component('mail::message')
# One Last Step

We just need you to confirm your address to prove that you're a human. yuo get it, right? Cool.

@component('mail::button', ['url' => url('/register/confirm?token=' . $user->confirmation_token)])
Confirm Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
