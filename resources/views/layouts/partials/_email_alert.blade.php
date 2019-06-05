@if(session('email_error') != null)
    <div class="alert alert-warning">
        <ul>
            <li>{{ session('email_error') }}</li>
        </ul>
    </div>
@endif

@if (!Auth::guest() && !auth()->user()->confirmed)
    <div class="alert alert-warning alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        邮箱未激活，请前往 {{ Auth::user()->email }} 查收激活邮件。未收到邮件？请前往 <a href="{{ route('users.send-verification-mail') }}" class="alert-link">重新发送>></a> 。
    </div>
@endif