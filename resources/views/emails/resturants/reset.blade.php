@component('mail::message')
    <h3>Reset Password </h3>
    Hi {{$resturant->name}}
    Your pin code is:{{$resturant->pin_code}}
    Thanks,
    {{ config('app.name') }}
@endcomponent
