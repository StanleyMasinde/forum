@component('mail::message')
# Post Reported

@component('mail::panel')
The following post has been reported on the {{ env('APP_NAME') }}: 
[{{ (strlen($post->body) > 25) ? str_limit($post->body, 24) . '&hellip;' : $post->body }}]({{ env('APP_URL') . '/forum/topics/' . $topic->slug . '#post-' . $post->id }})
@endcomponent

@component('mail::panel')
Please moderate the above post by editing it or deleting it. 
Make sure you also check your moderator dashboard:
[Moderator Dashboard]({{ env('APP_URL') . '/moderator/dashboard/' }})
for any other topics or posts that need moderating and to clear the moderation related to this email.
@endcomponent

@component('mail::panel')
If the above links didn't work, 
please copy and paste the following URLs into your Browser's address bar: _{{ env('APP_URL') . '/forum/topics/' . $topic->slug . '#post-' . $post->id }}_, _{{ env('APP_URL') . '/moderator/dashboard/' }}_
@endcomponent

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
