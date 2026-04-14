<?php

namespace App\Notifications;

use App\Filament\Resources\SubscriptionResource;
use App\Models\Subscription;
use Illuminate\Notifications\Notification;

class SubscriptionLowMinutesNotification extends Notification
{
    public function __construct(private readonly Subscription $subscription) {}

    public function via(object $notifiable): array
    {
        return ['database'];
        // TODO: decommentare in produzione
        // return ['database', 'mail'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title'   => __('notifications.subscription_low_minutes.title'),
            'body'    => __('notifications.subscription_low_minutes.body', [
                'company'   => $this->subscription->company?->name ?? '-',
                'remaining' => $this->subscription->minutes_remaining,
                'total'     => $this->subscription->plan?->total_minutes ?? 0,
            ]),
            'status'  => 'warning',
            'actions' => [
                [
                    'name'  => 'view',
                    'label' => __('notifications.actions.view_ticket'),
                    'url'   => SubscriptionResource::getUrl('edit', ['record' => $this->subscription]),
                ],
            ],
        ];
    }

    // TODO: decommentare in produzione
    // public function toMail(object $notifiable): MailMessage { ... }
}
