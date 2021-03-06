<!DOCTYPE html>
<html lang="en">



	<head>
	
		<title>Event SPA - Appetiser</title>
		<meta charset="utf-8">
		
		<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
	
	</head>



  <body>

	
  
    <div class="container" id="app">
		<v-app>
			
			
			<br>
			<h1 class="text-left">Calendar App</h1>
			<br>
			<v-alert v-model="alert" border="left" close-text="Close Alert" color="orange" dark dismissible >
				For more info, please refer to the <strong>ReadMe.txt</strong> at github repository root. Thank you.		
			</v-alert>
			<br>


      <div class="" >
        <div class="card">

		<v-row>
			
			<v-col>
			<div id="calendar_form">

				<v-text-field label="Event Name" v-model="eventName"></v-text-field>

				
				<v-menu v-model="menu" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
					<template v-slot:activator="{ on, attrs }">
						<v-text-field v-model="startDate" label="Start Date" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
					</template>
					<v-date-picker v-model="startDate" @input="menu = false" ></v-date-picker>
				</v-menu>


				<v-menu v-model="menu2" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
					<template v-slot:activator="{ on, attrs }">
						<v-text-field v-model="endDate" label="End Date" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
					</template>
					<v-date-picker v-model="endDate" @input="menu2 = false" ></v-date-picker>
				</v-menu>

			</div>

			<br>

			<v-row>
				<div>
					<input type="checkbox" id="checkbox" v-model="monday">
					<label for="checkbox">Mon</label>
				</div>
				&nbsp; &nbsp;
				<div>
					<input type="checkbox" id="checkbox" v-model="tuesday">
					<label for="checkbox">Tue</label>
				</div>
				&nbsp; &nbsp;
				<div>
					<input type="checkbox" id="checkbox" v-model="wednesday">
					<label for="checkbox">Wed</label>
				</div>
				&nbsp; &nbsp;
				<div>
					<input type="checkbox" id="checkbox" v-model="thursday">
					<label for="checkbox">Thu</label>
				</div>
				&nbsp; &nbsp;
				<div>
					<input type="checkbox" id="checkbox" v-model="friday">
					<label for="checkbox">Fri</label>
				</div>
				&nbsp; &nbsp;
				<div>
					<input type="checkbox" id="checkbox" v-model="saturday">
					<label for="checkbox">Sat</label>
				</div>
				&nbsp; &nbsp;
				<div>
					<input type="checkbox" id="checkbox" v-model="sunday">
					<label for="checkbox">Sun</label>
				</div>
			</v-row>

			<br>

			<v-progress-linear v-if="loading" indeterminate color="teal"></v-progress-linear>

			<div v-if="!loading">
				<v-btn v-on:click="addEvent" depressed color="primary">Save</v-btn>
				<v-btn v-on:click="resetFields" class="ma-2" outlined color="red">Reset Fields</v-btn>	
			</div>
			
			<br><br>

			<v-alert v-if="successfulSave" dense border="left" type="info">
				Event saved successfuly.
		  	</v-alert>

			  <v-alert v-if="eventNameEmpty" dense border="left" type="error">
					Event name is required.
			  </v-alert>

			  <v-alert v-if="startDateEmpty" dense border="left" type="error">
					Start Date cannot be empty.
			  </v-alert>

			  <v-alert v-if="endDateEmpty" dense border="left" type="error">
					End Date cannot be empty.
			  </v-alert>

			  <v-alert v-if="dateError" dense border="left" type="error">
					Start Date must be on or before End Date.
			  </v-alert>

			  <v-alert v-if="serverError" dense border="left" type="error">
					Server error.
			  </v-alert>

		</v-col>

		
		<v-divider vertical></v-divider>
		

			<v-col>
				<div id="calendar_widget">

					<h2>{{getMonthAndYear(currentDate)}}</h2>

					<br>

					<div v-for="index in 31" :key="index">
						<div :class="hasEvent(addDays(getStartOfMonth(currentDate), index)) ? 'withEvent' : 'withoutEvent'"  id="calendarDate">
							<span v-if="sameMonth(currentDate, addDays(getStartOfMonth(currentDate), index))"> {{getDateAndDay(addDays(getStartOfMonth(currentDate), index))}} </span>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
							<span v-if="hasEvent(addDays(getStartOfMonth(currentDate), index))"> {{recentlyAddedEvent.name}} </span>
						</div>
					</div>

				</div>
			</v-col>

		</v-row>
				
          </div>
        </div>
      </div>
	</v-app>
    </div>




<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
	var app = new Vue({
		el: '#app',
		vuetify: new Vuetify(),
		data: () => ({
			// Form-related values
			eventName: '',
			startDate: '',
			endDate: '',
			currentDate: new Date(),
			sunday: false,
			monday: false,
			tuesday: false,
			wednesday: false,
			thursday: false,
			friday: false,
			saturday: false,
			menu: false,
			menu2: false,
			loading: false,
			// Form checking-related values
			eventNameEmpty: false,
			startDateEmpty: false,
			endDateEmpty: false,
			successfulSave: false,
			serverError: false,
			dateError: false,
			// API-related values
			recentlyAddedEvent: null,
			// extra variables
			alert: true,
		}),
		methods: {
			// receives -
			// used in -
			// returns - 
			getMonthAndYear: function (date) {
				return date.toLocaleString('en-us',{month:'long', year:'numeric'});
			},
			// receives -
			// used in -
			// returns - 
			getStartOfMonth: function (date) {
				return new Date(date.getFullYear(), date.getMonth(), 1, 0, 0, 0, 0);
			},
			// receives -
			// used in -
			// returns - 
			getDateAndDay: function (date) {
				// console.log(date);
				return  date.toLocaleString('en-us',{day:'numeric'}) + ' - ' + date.toLocaleString('en-us',{weekday:'short'});
			},
			// receives -
			// used in -
			// returns - 
			addDays: function (date, days) {
				date.setDate(date.getDate() + days-1);
				return date;
			},
			// receives -
			// used in -
			// returns - 
			sameMonth: function (currentDate, newDate) {
				// console.log(newDate);
				if(currentDate.getMonth()==newDate.getMonth()) return true;
				return false;
			},
			// receives -
			// used in -
			// returns - 
			logValues: function () {
				console.log('');
				console.log(`start date: ${this.date}`);
				console.log(`end date: ${this.date2}`);
				console.log(`current date: ${this.currentDate}`);
				console.log(`event name: ${this.eventName}`);
				console.log('');
			},
			// receives -
			// used in -
			// returns - 
			addEvent: async function ()  {
								

				if(!this.hasFormErrors()) {

					var data = {
						name: this.eventName,
						date_start: this.startDate,
						date_end: this.endDate,
						sunday: this.sunday,
						monday: this.monday,
						tuesday: this.tuesday,
						wednesday: this.wednesday,
						thursday: this.thursday,
						friday: this.friday,
						saturday: this.saturday,
					}
					
					try {

						
						this.loading = true;

						$requestResponse = await axios({
							method: 'post',
							// baseURL: `https://ancient-plateau-26754.herokuapp.com/`,
							baseURL: `http://localhost:8000`,
							url: `/api/event/add`,
							data: data,
						}).then((response) => {
							this.recentlyAddedEvent = response.data;
						});

						this.successfulSave = true;
						setTimeout(() => this.successfulSave = false, 3000);

					} catch (e) {
						this.serverError=true;
						this.recentlyAddedEvent = null;
						console.log(e);
					}
				
				
				this.loading = false;
				
				}
			},
			// receives -
			// used in -
			// returns - 
			resetFields: function () {
				this.eventName = '',
				this.startDate = '',
				this.endDate = '',
				this.currentDate = new Date(),
				this.sunday = false,
				this.monday = false,
				this.tuesday = false,
				this.wednesday = false,
				this.thursday = false,
				this.friday = false,
				this.saturday = false,
				this.menu = false,
				this.menu2 = false,
				this.eventNameEmpty = false,
				this.startDateEmpty = false,
				this.endDateEmpty = false,
				this.successfulSave = false,
				this.serverError = false,
				this.dateError= false,
				this.recentlyAddedEvent = null
			},
			// receives -
			// used in -
			// returns - 
			isBefore: function (date1, date2)  {
				var newDate1 = this.getDateFormat(date1); 
				var newDate2 = this.getDateFormat(date2); 
				
				return (newDate1.getTime()>newDate2.getTime());
			},
			// receives -
			// used in -
			// returns - 
			isWithin: function (compareDate, date1, date2)  {
				var newDate1 =  this.getDateFormat(date1); 
				var newDate2 =  this.getDateFormat(date2); 
				var newCd =  this.getDateFormat(compareDate); 
				
				return (newDate1.getTime()<=newCd.getTime() && newDate2.getTime()>=newCd.getTime());
			},
			// receives -
			// used in -
			// returns - 
			getDateFormat: function (date) {
				var splitDate = date.split('-');
				var newDate = new Date(parseInt(splitDate[0]), parseInt(splitDate[1])-1, parseInt(splitDate[2]), 0, 0, 0, 0, ); 
				return newDate;
			},
			// receives -
			// used in -
			// returns - 
			getWeekDay: function (date) {
				var formatted = this.getDateFormat(date);
				return  formatted.getDay();
			},
			// receives -
			// used in -
			// returns - 
			hasEvent: function (date)  {
				date = [date.getFullYear(), date.getMonth()+1, date.getDate()].join('-');
				if(this.recentlyAddedEvent!=null) {
					if(this.isWithin(date, this.recentlyAddedEvent.date_start, this.recentlyAddedEvent.date_end)) {
						var weekday = this.getWeekDay(date);
						if(weekday==0 &&  this.recentlyAddedEvent.sunday) return true;
						if(weekday==1 &&  this.recentlyAddedEvent.monday) return true;
						if(weekday==2 &&  this.recentlyAddedEvent.tuesday) return true;
						if(weekday==3 &&  this.recentlyAddedEvent.wednesday) return true;
						if(weekday==4 &&  this.recentlyAddedEvent.thursday) return true;
						if(weekday==5 &&  this.recentlyAddedEvent.friday) return true;
						if(weekday==6 &&  this.recentlyAddedEvent.saturday) return true;
						return false;
					}
				}
				return false; 
			},
			// receives -
			// used in -
			// returns - 
			hasFormErrors: function ()  {
				
				var hasErrors = false;

				if(this.eventName=='') {
					hasErrors=true;
					this.eventNameEmpty=true;
				} else this.eventNameEmpty=false;

				if(this.startDate=='') {
					hasErrors=true;
					this.startDateEmpty=true;
				} else this.startDateEmpty=false;

				if(this.endDate=='') {
					hasErrors=true;
					this.endDateEmpty=true;
				} else this.endDateEmpty=false;

				if(this.endDate!='' && this.startDate!='')
					if(this.isBefore(this.startDate,this.endDate)) {
						hasErrors=true;
						this.dateError=true;
					} else this.dateError=false;

				return hasErrors;
			},
		},
	});
</script>
	


<style scoped>
	#calendarDate {
		border-top: 1px solid black;
	}
	.withEvent {
		padding: 15px;
		background-color: rgb(179, 179, 255);
	}
	.withoutEvent {
		padding: 15px;
		background-color: white;
	}
</style>
	
	
</body>
</html>