# EduDonate Form Submission Fix

## Completed Tasks
- [x] Update db_connect.php to use "localhost" instead of "127.0.0.1:3307"
- [x] Add error reporting to login.php
- [x] Add error reporting to Admin-portal/register.php
- [x] Change table name from 'registrations' to 'fundraiser_login' in db_connect.php
- [x] Update register.php to insert into fundraiser_login table and redirect to login page
- [x] Update login.php to check fundraiser_login table for authentication
- [x] Verify forms submit to correct PHP scripts (already correct)

## Pending Tasks
- [ ] Start Apache and MySQL in XAMPP control panel
- [ ] Access the site via http://localhost/EduDonate/ (not by opening HTML files directly)
- [ ] Test form submissions for signup, donation, register, and login forms
- [ ] Verify data is being stored in the database tables (users, donations, fundraiser_login)

## Notes
- The connection error indicates MySQL is not running in XAMPP - user needs to start MySQL service
- All PHP scripts are syntactically correct and should work once the server is running
- Database connection now uses default localhost port (3306)
- Error reporting has been enabled in all form processing scripts to help debug any remaining issues
- Registration form now redirects to login page after successful registration
- Login authentication now checks the fundraiser_login table
