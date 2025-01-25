1. Clone this Repository https://github.com/Siddhesh221398/task-manager.git

2. Composer update

3. Rename .env.example to .env 

4. Create Db in Mysql and named taskmanager

5. Run Migration command to add tables -> php artisan migrate

6. To Create Admin User execute command -> php artisan db:seed 

7. Add Smtp and pusher credential's in .env file 

8. Run the Project

9. Postman collection and environment file are attached in mail. Imports both file in postman

10. After that you can Register/Login by run api of Authentication Folder

11. Then after you can run another apis related user crud and task crud 

12.	To run cron execute this command -> php artisan tasks:check-overdue 