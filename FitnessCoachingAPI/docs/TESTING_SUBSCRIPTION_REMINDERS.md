# Testing Subscription Renewal Reminders

## Quick Test Guide

### Method 1: Using Laravel Tinker (Recommended)

1. **Open Laravel Tinker:**
   ```bash
   php artisan tinker
   ```

2. **Create a test coach (if you don't have one):**
   ```php
   $admin = \App\Models\Admin::getMainAdmin();
   $coach = \App\Models\Coach::create([
       'admin_id' => $admin->id,
       'full_name' => 'Test Coach',
       'email' => 'coach@test.com',
       'password' => bcrypt('password'),
   ]);
   ```

3. **Create a test client with expiring subscription (expires in 3 days):**
   ```php
   $client = \App\Models\Client::create([
       'coach_id' => $coach->id,
       'full_name' => 'Test Client',
       'email' => 'client@test.com',
       'password' => bcrypt('password'),
       'status' => 'active',
       'subscription_type' => 'monthly',
       'subscription_expires_at' => now()->addDays(3), // Expires in 3 days
   ]);
   ```

4. **Create another client expiring in 7 days:**
   ```php
   $client2 = \App\Models\Client::create([
       'coach_id' => $coach->id,
       'full_name' => 'Test Client 2',
       'email' => 'client2@test.com',
       'password' => bcrypt('password'),
       'status' => 'active',
       'subscription_type' => 'monthly',
       'subscription_expires_at' => now()->addDays(7), // Expires in 7 days
   ]);
   ```

5. **Exit tinker:**
   ```php
   exit
   ```

### Method 2: Using SQL Directly

You can also use a database tool or phpMyAdmin to directly update a client's subscription expiration:

```sql
UPDATE clients 
SET subscription_expires_at = DATE_ADD(NOW(), INTERVAL 3 DAY), 
    status = 'active'
WHERE email = 'your-client-email@example.com';
```

## Testing Steps

### Step 1: Verify Dashboard Display

1. **Login as Admin:**
   - Go to: `http://localhost:8000/login`
   - Email: `jayraldmicarandayo@gmail.com`
   - Password: `fitnesscoach`

2. **Check Admin Dashboard:**
   - You should see a new stat card showing "Expiring Subscriptions" count
   - If you created test clients, you should see the count (e.g., "2")

3. **Check Expiring Subscriptions Section:**
   - Scroll down to see the "Expiring Subscriptions (Next 7 Days)" section
   - You should see your test clients listed with:
     - Client name and email
     - Coach name
     - Subscription type
     - Expiration date
     - Days remaining (color-coded: red for ≤3 days, orange for 4-7 days)
     - "Send Reminder" button

### Step 2: Test Individual Reminder

1. **Click "Send Reminder" button** next to a client
2. **Check for success message** at the top of the page
3. **Check email** (if email is configured):
   - The client should receive an email with subject: "Subscription Renewal Reminder - Fitness Coaching"
   - Check your email inbox or mail logs

### Step 3: Test Bulk Reminders

1. **Click "Send Reminders to All" button** at the top
2. **Confirm the action** in the popup
3. **Check for success message** showing how many reminders were sent
4. **Check emails** for all clients with expiring subscriptions

### Step 4: Verify Email Content

The email should contain:
- Client's name
- Expiration date
- Days until expiration
- Subscription type
- Renewal reminder message

## Testing Different Scenarios

### Scenario 1: Client Expiring in 1 Day (Urgent)
```php
// In tinker:
$client->subscription_expires_at = now()->addDay();
$client->save();
```
- Should show red badge (≤3 days)
- Should appear in expiring subscriptions list

### Scenario 2: Client Expiring in 5 Days (Warning)
```php
// In tinker:
$client->subscription_expires_at = now()->addDays(5);
$client->save();
```
- Should show orange badge (4-7 days)
- Should appear in expiring subscriptions list

### Scenario 3: Client Expiring in 10 Days (Not Shown)
```php
// In tinker:
$client->subscription_expires_at = now()->addDays(10);
$client->save();
```
- Should NOT appear in expiring subscriptions list (only shows 0-7 days)

### Scenario 4: Already Expired Subscription
```php
// In tinker:
$client->subscription_expires_at = now()->subDays(1);
$client->save();
```
- Should NOT appear in expiring subscriptions list (only shows future dates)

### Scenario 5: Inactive Client
```php
// In tinker:
$client->status = 'inactive';
$client->save();
```
- Should NOT appear in expiring subscriptions list (only shows active clients)

## Checking Email Logs

If emails aren't being sent, check:

1. **Laravel Log:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Email Configuration:**
   - Check `.env` file for email settings
   - Verify `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, etc.

3. **Test Email:**
   ```bash
   php artisan email:test
   ```

## Quick Test Script

Run this in tinker to create all test scenarios at once:

```php
$admin = \App\Models\Admin::getMainAdmin();
$coach = \App\Models\Coach::firstOrCreate(
    ['email' => 'testcoach@example.com'],
    [
        'admin_id' => $admin->id,
        'full_name' => 'Test Coach',
        'password' => bcrypt('password'),
    ]
);

// Client expiring in 1 day (urgent)
\App\Models\Client::create([
    'coach_id' => $coach->id,
    'full_name' => 'Urgent Client',
    'email' => 'urgent@test.com',
    'password' => bcrypt('password'),
    'status' => 'active',
    'subscription_type' => 'monthly',
    'subscription_expires_at' => now()->addDay(),
]);

// Client expiring in 5 days (warning)
\App\Models\Client::create([
    'coach_id' => $coach->id,
    'full_name' => 'Warning Client',
    'email' => 'warning@test.com',
    'password' => bcrypt('password'),
    'status' => 'active',
    'subscription_type' => 'monthly',
    'subscription_expires_at' => now()->addDays(5),
]);

echo "Test clients created! Check admin dashboard.\n";
```

## Expected Results

✅ **Dashboard shows:**
- Expiring Subscriptions stat card with count
- Expiring Subscriptions section with client list
- Color-coded days remaining badges
- Send Reminder buttons

✅ **Reminder functionality:**
- Individual reminder sends email to specific client
- Bulk reminder sends emails to all expiring clients
- Success messages appear after sending

✅ **Email content:**
- Professional formatting
- Client name
- Expiration date
- Days remaining
- Subscription type
- Renewal call-to-action

