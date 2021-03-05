SWITCH THE CDN TO PRODUCTION
ADD LOADING WHEN ADDING STUFF

Features
	- Calendar App - Single Page Application
	- Store Events Created on MySql Database using Laravel
	- View Recently Added Event Immediately

Limitations
	- Non-Reuse of Vue Components in different Vue files
	- Non-Responsive CSS
	- Logic and View in one file
	- No authentication protection, anyone with the link can add events to the database.

Error Handling
	- Empty Form Inputs
	- Proper Datepicker Input
	- HTTTP Request Error

Used Plugins
	- Vuetify JS CDN
	- Vuetify CSS CDN
	- Vue CDN
	- Axios CDN

Laravel Endpoint(s)
	- post: api/events/add - Adds an event to the database. If successful, returns the data of the stored event

Cloning the Project
	1. Clone Repository
	2. Change directory to the cloned repository
	3. run composer install
	4. run npm install
	5. Modify .env file database settings, to suit your needs. Laravel needs an existing database to work on.
	6. Run php artisan migrate.
	7. Run php artisan serve.
	8. Open index.html as a normal webpage.