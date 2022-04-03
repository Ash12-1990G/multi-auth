@component('mail::message')
# Greetings!

Dear {{$mailData['name']}},

Thanks for being part of our community - we're so glad you're here. <br>

<b>Your new login details</b><br>
Email: {{ $mailData['email'] }}<br>
Password: {{ $mailData['password'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
