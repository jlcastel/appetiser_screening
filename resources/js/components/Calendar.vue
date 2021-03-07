<template>
    <v-col>
		<div id="calendar_widget">

			<h2>{{getMonthAndYear(currentDate)}}</h2>

			<br>

			<div v-for="index in 31" :key="index">
				
				<div :class="hasEvent(addDays(getStartOfMonth(currentDate), index)) ? 'withEvent' : 'withoutEvent'"  id="calendarDate">

					<span v-if="sameMonth(currentDate, addDays(getStartOfMonth(currentDate), index))">
						{{getDateAndDay(addDays(getStartOfMonth(currentDate), index))}}
					</span>

					&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

					<span v-if="hasEvent(addDays(getStartOfMonth(currentDate), index))">
						{{recentlyAddedEvent.name}}
					</span>

				</div>

			</div>

		</div>
	</v-col>
</template>



<script>
export default {
	props: {
		currentDate: Date,
		recentlyAddedEvent: Object
	},
	methods: {
		// description - determines if the received date has an event or not 
		// receives - a date in native Date type
		// returns - true if it is within the range of the recently saved date & is a weekday of the event 
		hasEvent(date)  {
			date = [date.getFullYear(), date.getMonth()+1, date.getDate()].join('-');
			if(this.recentlyAddedEvent!=null) {
				if(this.isWithin(date, this.recentlyAddedEvent.date_start, this.recentlyAddedEvent.date_end)) {
					var weekday = this.getWeekDay(date);
					if(weekday==0 && this.recentlyAddedEvent.sunday) return true;
					if(weekday==1 && this.recentlyAddedEvent.monday) return true;
					if(weekday==2 && this.recentlyAddedEvent.tuesday) return true;
					if(weekday==3 && this.recentlyAddedEvent.wednesday) return true;
					if(weekday==4 && this.recentlyAddedEvent.thursday) return true;
					if(weekday==5 && this.recentlyAddedEvent.friday) return true;
					if(weekday==6 && this.recentlyAddedEvent.saturday) return true;
					return false;
				}
			}
			return false; 
		},
		// description - determines if a date is within the range of 2 other dates
		// receives - 3 date strings of format 'YYYY-MM-DD'
		// returns - true if the 1st param is on or within the range of 2st param and 3rd param 
		isWithin: function (compareDate, date1, date2)  {
			var newDate1 =  this.getNativeDateFormat(date1); 
			var newDate2 =  this.getNativeDateFormat(date2); 
			var newCd =  this.getNativeDateFormat(compareDate); 
			
			return (newDate1.getTime()<=newCd.getTime() && newDate2.getTime()>=newCd.getTime());
		},
		// receives - a date (native Date type)
		// returns a user-readable string of month and yr, ex: April 2022
		getMonthAndYear(date) {
			return date.toLocaleString('en-us', {month:'long', year:'numeric'});
		},
		// helper function
		// receives - a string date of format 'YYYY-MM-DD'
		// returns - the equivalent native js Date type
		getNativeDateFormat (date) {
			var splitDate = date.split('-');
			var newDate = new Date(parseInt(splitDate[0]), parseInt(splitDate[1])-1, parseInt(splitDate[2]), 0, 0, 0, 0, ); 
			return newDate;
		},
		// receives - a native Date type 
		// returns - a user readable String for the date and day
		// description - used to show the days of the month
		getDateAndDay(date) {
			return  date.toLocaleString('en-us',{day:'numeric'}) + ' - ' + date.toLocaleString('en-us',{weekday:'short'});
		},
		// receives - a string date of format 'YYYY-MM-DD'
		// returns - its equivalent day of the week in number
		getWeekDay: function (date) {
			var formatted = this.getNativeDateFormat(date);
			return  formatted.getDay();
		},
		// helper function
		// description - determines if the received dates have the same month
		// use - prevents the calendar widget to show extra months if the month has less than 31 days
		// receives - two dates (native Date type)
		// returns - returns true if the two dates have the same month. otherwise, returns false
		sameMonth: function (currentDate, newDate) {
			if(currentDate.getMonth()==newDate.getMonth()) return true;
			return false;
		},
		// helper function
		// receives - a native Date type 
		// returns - the date of the first day of the received date
		// description - used to iterate through current month for the newly saved event
		getStartOfMonth(date) {
			return new Date(date.getFullYear(), date.getMonth(), 1, 0, 0, 0, 0);
		},
		// helper function to add a date with specific amount of days
		// receives - a native Date type & int type
		// returns - the 'date' with added number of 'days'
		addDays(date, days) {
			date.setDate(date.getDate() + days-1);
			return date;
		},
	}
}
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