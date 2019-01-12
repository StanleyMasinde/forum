@component('mail::message')
# Post Deleted


@component('mail::panel')
Your {{ env('APP_NAME') }} {{ $post->body }} post has been deleted.
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
