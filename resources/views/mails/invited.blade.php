@component('mail::message')
# Invitation
@component('mail::panel')
You have been invited to {{ env('APP_NAME') }} with a role of {{ $invite->role }}.
 

[Click here to register]({{ config('app.url').  '/register?code=' . $invite->code}})
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
