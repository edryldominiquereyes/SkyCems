@component('mail::message')

@component('mail::panel')
# {{ $bookData['greeting'] }}

<h2>{{ $bookData['body'] }}<h2>
@endcomponent

@component('mail::button', ['url' => '/', 'color'=>'success'])
Check
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
