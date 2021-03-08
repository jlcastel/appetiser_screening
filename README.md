# Appetiser Screening
Repository for Appetiser App's Screening

<img alt="Laravel" src="https://img.shields.io/badge/laravel%20-%23FF2D20.svg?&style=for-the-badge&logo=laravel&logoColor=white"/> <img alt="JavaScript" src="https://img.shields.io/badge/javascript%20-%23323330.svg?&style=for-the-badge&logo=javascript&logoColor=%23F7DF1E"/> <img alt="Vue.js" src="https://img.shields.io/badge/vuejs%20-%2335495e.svg?&style=for-the-badge&logo=vue.js&logoColor=%234FC08D"/> <img alt="MySQL" src="https://img.shields.io/badge/mysql-%2300f.svg?&style=for-the-badge&logo=mysql&logoColor=white"/> <img alt="HTML5" src="https://img.shields.io/badge/html5%20-%23E34F26.svg?&style=for-the-badge&logo=html5&logoColor=white"/> <img alt="CSS3" src="https://img.shields.io/badge/css3%20-%231572B6.svg?&style=for-the-badge&logo=css3&logoColor=white"/> <img alt="Material UI" src="https://img.shields.io/badge/material%20ui%20-%230081CB.svg?&style=for-the-badge&logo=material-ui&logoColor=white"/> <img alt="GitHub" src="https://img.shields.io/badge/github%20-%23121011.svg?&style=for-the-badge&logo=github&logoColor=white"/>

## Features
- Calendar App - Single Page Application
- Store Events Created on MySql Database using Laravel API
- View Recently Added Event Immediately
- Reset Form Input

## Limitations
- No Authentication - Anyone with the link can insert an event
- Vue still on Production mode
- Non-Responsive CSS
- MySql not accepting whitespace only - app prompts user w/ server error

## Error Handling
- Empty Form Inputs
- Proper Datepicker Input
- HTTTP Request Error

## Used Plugins
- Vue
- Vuetify
- Axios


## Laravel Endpoint(s)
- `POST: api/events/add` - Adds an event to the database. If successful, returns the data of the stored event.
- `GET:  api/events` - Returns all events on the database.

## MySql Database
	
