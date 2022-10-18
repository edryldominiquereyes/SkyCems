@component('mail::message')

@component('mail::panel')
# {{ $notify['greeting'] }}

<h2>{{ $notify['body'] }}<h2>
@endcomponent

@component('mail::button', ['url' => '/', 'color'=>'success'])
Check
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
