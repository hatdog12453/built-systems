# Postman Setup Guide - Automatic Token Management

## 🚀 Quick Start

1. **Import the Collection**
   - Open Postman
   - Click "Import" 
   - Select `docs/postman_full_collection_v2.json` (recommended) or `docs/postman_full_collection.json`

2. **Set Your Base URL**
   - The collection is pre-configured with `http://127.0.0.1:8000`
   - If your server runs on a different port, update the `baseUrl` variable

3. **Start Testing!**
   - Run any login request (Admin, Coach, or Client)
   - The token will be automatically saved
   - All other requests will use the saved token automatically

## 🔑 How Token Management Works

### Automatic Features:
- ✅ **Auto Token Extraction**: Login requests automatically extract and save tokens
- ✅ **Auto Token Usage**: All protected endpoints use the saved token
- ✅ **Role Tracking**: Tracks user role (admin/coach/client) and user info
- ✅ **Auto Logout**: Logout clears all saved tokens
- ✅ **Smart Warnings**: Shows helpful messages when no token is found

### What Gets Saved:
- `token` - The authentication token
- `user_id` - Current user's ID
- `user_role` - Current user's role (admin/coach/client)
- `user_email` - Current user's email

## 📋 Testing Workflow

### 1. First Time Setup:
```
1. Run "Auth > Register - Admin" (creates admin user)
   - URL: POST /api/auth/admin/register
   - Body: { "full_name": "...", "email": "...", "password": "...", "security_question": "..." (optional), "security_answer": "..." (optional) }
2. Run "Auth > Login - Admin" (gets token automatically)
   - URL: POST /api/auth/admin/login
   - Body: { "email": "...", "password": "..." }
3. Now all admin endpoints work automatically!
```

**Important:** The route format is `/api/auth/{role}/register` (auth comes BEFORE the role). 
Wrong: `/api/admin/auth/register` ❌
Correct: `/api/auth/admin/register` ✅

### 2. Switch Users:
```
1. Run "Auth > Login - Coach" (switches to coach token)
2. Now all coach endpoints work with coach permissions
3. Run "Auth > Login - Client" (switches to client token)
4. Now all client endpoints work with client permissions
```

### 3. Logout:
```
1. Run "Auth > Logout" (clears all tokens)
2. You'll need to login again for protected endpoints
```

## 🎯 Available Endpoints

### Admin Only (requires admin login):
- Admins CRUD
- Coaches CRUD  
- Clients CRUD
- Payments CRUD

### Coach Only (requires coach login):
- List my clients
- Meal Plans CRUD
- Session Plans CRUD
- Progress Trackers CRUD

### Client Only (requires client login):
- Get my details

## 🔧 Troubleshooting

### "Unauthenticated" Error:
- Run any login request first
- Check the Console tab for token status

### "Forbidden" Error:
- You're logged in as the wrong role
- Switch to the correct login (admin/coach/client)

### Server Not Running:
- Make sure Laravel server is running: `php artisan serve`
- Check the baseUrl variable is correct

## 💡 Pro Tips

1. **Check Console**: Always check the Console tab for helpful messages
2. **Role Switching**: You can switch between users anytime by running different logins
3. **Token Status**: The pre-request script shows your current token status
4. **Environment Backup**: Tokens are saved to both collection and environment variables

## 🎉 You're All Set!

Your Postman collection now has full automatic token management. No more manual copy-pasting! 🚀
