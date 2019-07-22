@component('mail::message')
    <h3>Reset Password </h3>
    Hi {{$client->name}}
    Your pin code is:{{$client->pin_code}}
    Thanks,
    {{ config('app.name') }}
@endcomponent
