<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravelista\Comments\Events\CommentCreated;
use Laravelista\Comments\Events\CommentDeleted;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        'App\Events\ThreadHasNewReply' => [ // 订阅话题监听
            'App\Listeners\NotifyThreadSubscribers'
        ],
        'App\Events\ThreadReceivedNewReply' => [ // @某人事件监听
            'App\Listeners\NotifyMentionedUsers'
        ],

        Registered::class => [
            'App\Listeners\SendEmailConfirmationRequest'
        ],

        CommentCreated::class => [ // 创建评论时监听,记录活动日志
            'App\Listeners\CreatedCommentsRecordLog'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
