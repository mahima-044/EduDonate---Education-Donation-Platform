- [x] Fix malformed HTML in donate.html: remove duplicate </body> and </html>, move script tag inside body
- [x] Remove or update inline script to prevent JS errors
- [x] Test the page visibility by opening in browser
- [x] Fix database storage: Update donate_process.php to handle custom_amount binding, add final_amount logic, improve validation
- [x] Create thank_you.html for post-donation redirect
- [x] Update donate.html: Add required attributes, hidden final_amount field
- [x] Update script.js: Add custom amount handling, client-side validation, dynamic summary
- [x] Test donation form submission and DB insert

## Fixing Donation Data Storage Issue

- [x] Update TODO.md with new steps for debugging and fixing storage
- [x] Edit donate_process.php: Scale amounts by 1000 (e.g., 2 -> 2000)
- [x] Edit donate_process.php: Add var_dump($_POST) and detailed error logging for connection, prepare, execute
- [x] Edit donate_process.php: Modify success feedback to avoid hiding errors (e.g., echo success message)
- [x] Test form submission: Submit a test donation and verify data in phpMyAdmin 'donations' table
- [x] Update TODO.md: Mark completed steps and remove debugging code if successful

## Creating Admin Side for Viewing Donations

- [x] Update TODO.md with steps for admin page
- [x] Create admin.php: Fetch and display all donations in a table (id, name, email, phone, impact, type, amount, custom, date)
- [x] Test admin.php: Access via browser and verify data display
- [x] Optionally: Remove debugging from donate_process.php once confirmed working
