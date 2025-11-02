# TODO: Fix Admin Portal Database Issue

- [x] Update db_connect.php to change database name from "ngo_portal" to "ngo_users" in the second connection block.
- [x] Add creation of ngo_users table in db_connect.php after connecting to the database, including columns: id (auto increment primary key), organization_name, email (unique), password, created_at.
- [x] Test registration and login to ensure data is stored and retrieved correctly from ngo_users table.
