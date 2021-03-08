<template>
    <div class="container">
        <v-app>
            
            <Header-Bar/>

            <div>
                <v-row>
                    <v-col>

                        <form id="add-event-form" @submit.prevent="addEvent">

                            <v-text-field label="Event Name" v-model="eventName"></v-text-field>

                            <Datepicker :datePickerLabel="'Start Date'" v-model="startDate" @valueChanged="startDate=$event"/>
                            <Datepicker :datePickerLabel="'End Date'" v-model="endDate" @valueChanged="endDate=$event"/>
                            
                            <br>

                            <v-row>
                                <div> <input type="checkbox" id="checkbox" v-model="monday">    Mon &nbsp; &nbsp; </div>
                                <div> <input type="checkbox" id="checkbox" v-model="tuesday">   Tue &nbsp; &nbsp; </div> 
                                <div> <input type="checkbox" id="checkbox" v-model="wednesday"> Wed &nbsp; &nbsp; </div> 
                                <div> <input type="checkbox" id="checkbox" v-model="thursday">  Thu &nbsp; &nbsp; </div> 
                                <div> <input type="checkbox" id="checkbox" v-model="friday">    Fri &nbsp; &nbsp; </div> 
                                <div> <input type="checkbox" id="checkbox" v-model="saturday">  Sat &nbsp; &nbsp; </div> 
                                <div> <input type="checkbox" id="checkbox" v-model="sunday">    Sun </div>
                            </v-row>

                            <br>

                            <Loading-Bar v-if="loading"/>

                            <br>
                            
                            <v-row v-if="!loading">
                                <v-btn type="submit" class="ma-2" depressed color="primary">Save</v-btn>
                                <v-btn v-on:click="resetFields"  class="ma-2" outlined color="red">Reset Fields</v-btn>
                                <v-btn v-on:click="logValues"  class="ma-2" outlined color="black">Log Values</v-btn>
                            </v-row>
                        </form>

                        <br> <br>
                        
                        <AlertMessage v-if="successfulSave" :alertType="'info'"  :message="eventSaveSuccessMessage"/>
                        <AlertMessage v-if="eventNameEmpty" :alertType="'error'" :message="eventNameErrorMessage"/>
                        <AlertMessage v-if="startDateEmpty" :alertType="'error'" :message="startDateErrorMessage"/>
                        <AlertMessage v-if="endDateEmpty" :alertType="'error'" :message="endDateErrorMessage"/>
                        <AlertMessage v-if="dateError" :alertType="'error'" :message="dateErrorMessage"/>
                        <AlertMessage v-if="serverError" :alertType="'error'" :message="serverErrorMessage"/>

                    </v-col>

                    <v-divider vertical></v-divider>

                    <v-col>
                        <Calendar-Widget :currentDate="currentDate" :recentlyAddedEvent="this.recentlyAddedEvent"/>
                    </v-col>
                        
                </v-row>
            </div>
        </v-app>
    </div>
</template>




<script>

    // Header Component Imports
    import headerBar from './Header';
    // Calendar Component Imports
    import calendarWidget from './Calendar';
    // From Component Imports
    import datePicker from './form/Datepicker';
    import loadingBar from './form/LoadingBar';
    import alertMessage from './form/Alert';


    export default {
        name: 'App',
        components: {
            // Header Components
            'Header-Bar': headerBar,
            // Calendar Components
            'Calendar-Widget': calendarWidget,
            // Form Components
            'Datepicker': datePicker,
            'Loading-Bar': loadingBar,
            'AlertMessage': alertMessage,
        },
        data() {
            return {
                // Form-related values
                startDate: '',
                endDate: '',
			    eventName: '',
                sunday: false,
                monday: false,
                tuesday: false,
                wednesday: false,
                thursday: false,
                friday: false,
                saturday: false,
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
                // Calendar Widget values
			    currentDate: new Date(),
                // Constants - transfer to config file??
                eventSaveSuccessMessage: "Event saved successfuly.",
                eventNameErrorMessage: "Event Name required.",
                endDateErrorMessage: "End Date required.",
                startDateErrorMessage: "Start Date required.",
                dateErrorMessage: "Start Date must be on or before End Date.",
                serverErrorMessage: "Server error.",
            }
        },
        methods: {
            // used by add event button
            // calls the laravel api to send POST request to the laravel API
            // uses the form field values as request data 
            async addEvent()  {

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

						await axios({
							method: 'post',
							baseURL: `https://phplaravel-559756-1801932.cloudwaysapps.com/`,
							// baseURL: `http://localhost:8000`,
							url: `/api/event/add`,
							data: data,
						}).then((response) => {
							this.recentlyAddedEvent = response.data;
						});

                        
						this.serverError=false;

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
            // resets the values of the input fields to blank
            // resets the recentlyAddedEvent to be null
            resetFields() {
                // reset fields
                console.log('resetFields');
                this.eventName = "";
                this.startDate = "";
                this.endDate = "";
                this.sunday = false;
                this.monday = false;
                this.tuesday = false;
                this.wednesday = false;
                this.thursday = false;
                this.friday = false;
                this.saturday = false;
                // clear errors
                this.eventNameEmpty = false;
                this.startDateEmpty = false;
                this.endDateEmpty = false;
                this.successfulSave = false;
                this.serverError = false;
                this.dateError = false;
                // reset calendar ??
                this.recentlyAddedEvent = null;
			},
            // DEBUG FUNCTION - helper function
            // displays the value of the input fields
			logValues() {
                console.log('');
                console.log('');
                console.log(`eventName: ${this.eventName}`);
                console.log('- - - - -');
                console.log(`startDate: ${this.startDate}`);
                console.log(`endDate: ${this.endDate}`);
                console.log('- - - - -');
                console.log(`sunday: ${this.sunday}`);
                console.log(`monday: ${this.monday}`);
                console.log(`tuesday: ${this.tuesday}`);
                console.log(`wednesday: ${this.wednesday}`);
                console.log(`thursday: ${this.thursday}`);
                console.log(`friday: ${this.friday}`);
                console.log(`saturday: ${this.saturday}`);
                console.log('');
                console.log('');
            },
            // checks the form for errors
            // returns true if has errors, else return false
			hasFormErrors()  {
				
				var hasErrors = false;

                // event name
				if(this.eventName=='') {
					hasErrors=true;
					this.eventNameEmpty=true;
				} else this.eventNameEmpty=false;

                // datepicker - start date
				if(this.startDate=='') {
					hasErrors=true;
					this.startDateEmpty=true;
				} else this.startDateEmpty=false;

                // datepicker - start date
				if(this.endDate=='') {
					hasErrors=true;
					this.endDateEmpty=true;
				} else this.endDateEmpty=false;

                // datepicker - start date
				if(this.endDate!='' && this.startDate!='')
					if(this.isBefore(this.startDate,this.endDate)) {
						hasErrors=true;
						this.dateError=true;
					} else this.dateError=false;

				return hasErrors;
            },
            // receives - a date of type string with format 'YYYY-MM-DD'
            // returns - its equivalent Date type
            getDateFormat: function (date) {
            var splitDate = date.split('-');
            var newDate = new Date(parseInt(splitDate[0]), parseInt(splitDate[1])-1, parseInt(splitDate[2]), 0, 0, 0, 0, ); 
            return newDate;
            },
            // description - helper function for form checking
            // receives - 2 values of type String - Date dormat YYYY-MM-DD
            // returns - true if date1 is before date2, otherwise, returns false
            isBefore: function (date1, date2)  {
				var newDate1 = this.getDateFormat(date1); 
				var newDate2 = this.getDateFormat(date2); 
				return (newDate1.getTime()>newDate2.getTime());
			},
        }
    }


</script>