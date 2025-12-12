<!DOCTYPE html>
<html>
<head>
    <title>Subscription Renewal Reminder</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #4F46E5;">Subscription Renewal Reminder</h2>
        
        <p>Hello {{ $client->full_name }},</p>
        
        <p>This is a friendly reminder that your fitness coaching subscription is expiring soon.</p>
        
        @if($client->subscription_expires_at)
            <p><strong>Expiration Date:</strong> {{ $client->subscription_expires_at->format('F d, Y') }}</p>
            @php
                $daysUntilExpiry = now()->diffInDays($client->subscription_expires_at, false);
            @endphp
            @if($daysUntilExpiry > 0)
                <p>Your subscription will expire in <strong>{{ $daysUntilExpiry }} {{ $daysUntilExpiry == 1 ? 'day' : 'days' }}</strong>.</p>
            @else
                <p>Your subscription has expired. Please renew to continue receiving our services.</p>
            @endif
        @endif
        
        @if($client->subscription_type)
            <p><strong>Subscription Type:</strong> {{ ucfirst($client->subscription_type) }}</p>
        @endif
        
        <p>To continue enjoying our fitness coaching services, please renew your subscription as soon as possible.</p>
        
        <p>If you have any questions or need assistance, please don't hesitate to contact us.</p>
        
        <p>Thank you for being a valued member of our fitness coaching community!</p>
        
        <p>Best regards,<br>
        Fitness Coaching Team</p>
    </div>
</body>
</html>

