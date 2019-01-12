@component('mail::message')
# New Subscription

A user subscribed to _'{{ $topic->title }}'._ We thought you would like to know.
    Check it out  [here]({{env('APP_URL') . '/forum/topics/' . $topic->slug }})

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
