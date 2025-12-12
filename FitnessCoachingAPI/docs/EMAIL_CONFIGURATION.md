# Email Configuration Guide for Laravel

This guide will help you configure email sending in your Laravel application for the Fitness Coaching system.

## Table of Contents
1. [Quick Setup (Mailtrap for Development)](#quick-setup-mailtrap-for-development)
2. [Gmail SMTP Configuration](#gmail-smtp-configuration)
3. [Production Email Services](#production-email-services)
4. [Testing Email](#testing-email)
5. [Troubleshooting](#troubleshooting)

---

## Quick Setup (Mailtrap for Development)

**Mailtrap** is perfect for development - it catches all emails without sending them to real recipients.

### Step 1: Create a Mailtrap Account
1. Go to [https://mailtrap.io](https://mailtrap.io)
2. Sign up for a free account
3. Create a new inbox

### Step 2: Get Your Credentials
1. In Mailtrap, go to your inbox
2. Click on "SMTP Settings"
3. Select "Laravel" from the dropdown
4. Copy the credentials shown

### Step 3: Update Your .env File
Open your `.env` file and add/update these lines:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@fitnesscoaching.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Replace:**
- `your_mailtrap_username` with your Mailtrap username
- `your_mailtrap_password` with your Mailtrap password

### Step 4: Clear Config Cache
```bash
php artisan config:clear
```

### Step 5: Test It!
Send a test email and check your Mailtrap inbox - you should see it there!

---

## Gmail SMTP Configuration

For using Gmail to send real emails (good for testing with real recipients).

### Step 1: Enable 2-Factor Authentication
1. Go to your Google Account settings
2. Enable 2-Factor Authentication

### Step 2: Create an App Password
1. Go to [Google App Passwords](https://myaccount.google.com/apppasswords)
2. Select "Mail" and "Other (Custom name)"
3. Enter "Laravel Fitness Coaching"
4. Click "Generate"
5. **Copy the 16-character password** (you'll need this!)

### Step 3: Update Your .env File
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_gmail@gmail.com
MAIL_PASSWORD=your_16_character_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_gmail@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Replace:**
- `your_gmail@gmail.com` with your Gmail address
- `your_16_character_app_password` with the app password from Step 2

### Step 4: Clear Config Cache
```bash
php artisan config:clear
```

---

## Production Email Services

For production, use professional email services:

### Option 1: Mailgun (Recommended)
1. Sign up at [mailgun.com](https://www.mailgun.com)
2. Verify your domain
3. Get your API credentials
4. Update `.env`:
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your_domain.com
MAILGUN_SECRET=your_mailgun_secret
MAILGUN_ENDPOINT=api.mailgun.net
MAIL_FROM_ADDRESS=noreply@your_domain.com
```

### Option 2: SendGrid
1. Sign up at [sendgrid.com](https://sendgrid.com)
2. Create an API key
3. Update `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your_sendgrid_api_key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your_domain.com
```

### Option 3: Amazon SES
1. Set up AWS SES
2. Verify your email/domain
3. Get SMTP credentials
4. Update `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=email-smtp.us-east-1.amazonaws.com
MAIL_PORT=587
MAIL_USERNAME=your_ses_username
MAIL_PASSWORD=your_ses_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your_domain.com
```

---

## Testing Email

### Method 1: Create a Test Route (Quick Test)
Add this to `routes/web.php` temporarily:

```php
Route::get('/test-email', function () {
    $client = \App\Models\Client::first();
    
    if (!$client) {
        return 'No client found. Please seed the database first.';
    }
    
    try {
        \Illuminate\Support\Facades\Mail::send('emails.client-approved', ['client' => $client], function ($message) use ($client) {
            $message->to($client->email, $client->full_name)
                ->subject('Test Email - Fitness Coaching');
        });
        
        return 'Email sent successfully! Check your inbox (or Mailtrap).';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
```

Then visit: `http://localhost:8000/test-email`

**Remember to remove this route after testing!**

### Method 2: Test Through the Application
1. Register a new client
2. Complete payment
3. Login as admin
4. Mark the payment as "Paid"
5. Check if the email was sent

### Method 3: Use Tinker (Command Line)
```bash
php artisan tinker
```

Then in Tinker:
```php
$client = App\Models\Client::first();
Mail::send('emails.client-approved', ['client' => $client], function ($message) use ($client) {
    $message->to($client->email, $client->full_name)
        ->subject('Test Email');
});
```

---

## Troubleshooting

### Problem: "Connection could not be established"
**Solution:**
- Check your `MAIL_HOST` and `MAIL_PORT`
- Verify your firewall isn't blocking the connection
- Try `MAIL_ENCRYPTION=null` for some SMTP servers

### Problem: "Authentication failed"
**Solution:**
- Double-check your username and password
- For Gmail, make sure you're using an App Password, not your regular password
- Verify credentials are correct in `.env`

### Problem: "Emails not sending"
**Solution:**
1. Clear config cache: `php artisan config:clear`
2. Check `.env` file has correct values
3. Verify `MAIL_FROM_ADDRESS` is valid
4. Check Laravel logs: `storage/logs/laravel.log`

### Problem: "Emails going to spam"
**Solution:**
- Use a professional email service (Mailgun, SendGrid)
- Verify your domain with SPF and DKIM records
- Use a proper `MAIL_FROM_ADDRESS` (not a free email)

---

## Environment Variables Reference

Here's a complete list of email-related variables for your `.env`:

```env
# Mail Driver
MAIL_MAILER=smtp

# SMTP Settings
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls

# From Address
MAIL_FROM_ADDRESS=noreply@fitnesscoaching.com
MAIL_FROM_NAME="${APP_NAME}"

# Mailgun (if using)
MAILGUN_DOMAIN=your_domain.com
MAILGUN_SECRET=your_secret
MAILGUN_ENDPOINT=api.mailgun.net
```

---

## Quick Checklist

- [ ] Updated `.env` file with email credentials
- [ ] Ran `php artisan config:clear`
- [ ] Tested email sending
- [ ] Verified email appears in inbox (or Mailtrap)
- [ ] Checked spam folder if using real email
- [ ] Removed test routes (if added)

---

## Next Steps

Once email is configured:
1. Test the client approval flow
2. Register a new client
3. Mark payment as paid as admin
4. Verify the client receives the approval email

**Need Help?**
- Check Laravel logs: `storage/logs/laravel.log`
- Laravel Mail Documentation: https://laravel.com/docs/mail
- Mailtrap Documentation: https://mailtrap.io/docs

