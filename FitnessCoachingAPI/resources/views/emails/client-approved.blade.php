<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Account Approved - Fitness Coaching</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #4F46E5;">Account Approved!</h1>
        <p>Dear {{ $client->full_name }},</p>
        <p>We are pleased to inform you that your account has been approved and is now active.</p>
        <p>You can now log in to your dashboard and start your fitness journey with us!</p>
        <div style="background-color: #F3F4F6; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Your Account Details:</strong></p>
            <p>Email: {{ $client->email }}</p>
            <p>Status: Active</p>
            @if($client->coach)
                <p>Assigned Coach: {{ $client->coach->full_name }}</p>
            @endif
        </div>
        <p>Please log in to access your personalized meal plans, workout sessions, and progress tracking.</p>
        <p style="margin-top: 30px;">Best regards,<br>The Fitness Coaching Team</p>
    </div>
</body>
</html>

