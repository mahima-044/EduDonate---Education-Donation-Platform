# Migration Plan: Move Backend from XAMPP to Cloud

## Step 1: Set Up Cloud Database (PlanetScale)
- Create a PlanetScale account (free tier available).
- Create a new database (MySQL-compatible).
- Note down the connection details (host, username, password, database name).

## Step 2: Migrate Database Schema and Data
- Export the current database from XAMPP (use phpMyAdmin or mysqldump).
- Import the schema and data into PlanetScale database.
- Update `db_connect.php` with new PlanetScale credentials.

## Step 3: Deploy PHP Backend to Railway
- Create a Railway account (free tier).
- Create a new project and connect your GitHub repo (or upload files).
- Configure the PHP app (Railway auto-detects PHP).
- Deploy the backend.
- Note the deployed URL (e.g., https://your-app.railway.app).

## Step 4: Update Frontend Form Actions
- Update form actions in HTML files to point to Railway URLs:
  - donate.html: action="https://your-app.railway.app/donate_process.php"
  - signup.html: action="https://your-app.railway.app/signup.php"
  - Admin-portal/create-request.html: action="https://your-app.railway.app/Admin-portal/submit-request.php"
  - Admin-portal/register.html: action="https://your-app.railway.app/Admin-portal/register.php"
  - login forms: action="https://your-app.railway.app/login.php" and "https://your-app.railway.app/Admin-portal/login.php"

## Step 5: Handle File Uploads
- Ensure upload directories exist on Railway (uploads/images/, uploads/documents/).
- Update file paths in PHP if needed (Railway uses absolute paths).

## Step 6: Test the Deployment
- Test form submissions on Vercel frontend to ensure data goes to Railway backend and PlanetScale DB.
- Verify file uploads work.

## Step 7: Update Environment Variables (if needed)
- If using env vars for DB credentials, set them in Railway dashboard.
