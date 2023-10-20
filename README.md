# ADDHubSystem

Python Scripts to create and import the test data are kept in the main branch. The Laravel Web application is found in the master branch.

How to set up the system:
First, you will need to download all the required software, such as WAMP, Python with the Faker and SQLAlchemy packages, and Composer for Laravel.
1. Run CreatingDummyData.ipynb with the number of extracts that you wish (examples given here are 100 and 100 000).
2. Run CreatingTables.ipynb with the last block of code commented out (makes all the tables ready to be added to the system).
3. Create a project folder in WAMP to hold all the code for the Laravel Web Application, which you can pull from the master branch.
4. Run the command "php artisan migrate" using Composer in the WAMP project folder to create the necessary table templates in the MySQL database.
5. Add each user using the Register page with the passwords you wish, in the order of the user ID assigned in CreatingTables.ipynb.
6. Uncomment the block of code in CreatingTables.ipynb, changing the credentials and name of the database to what you are using, and run that section (this will add all other table records).

From this point on, you should be able to use the web application as normal.
