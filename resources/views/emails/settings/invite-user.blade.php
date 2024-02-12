@component('mail::message')
# Welcome

You have been invited to the Andrus Project.

@component('mail::panel')
    Username: {{ $user->email }}<br />
    Password: {{ $password }}
@endcomponent

@component('mail::button', ['url' => route('login')])
Click Here To Login
@endcomponent

@endcomponent
