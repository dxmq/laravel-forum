@component('mail::message')

    我们需要验证你的邮箱地址，以确保邮箱合法！

@component('mail::button', ['url' => url('/register/confirm?token=' . $user->confirmation_token)])
验证邮箱
@endcomponent

谢谢，<br>
{{ config('app.name') }}
@endcomponent
