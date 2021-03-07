<template>
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
</template>



<script>
export default {
	props: {
		currentDate: Date,
		recentlyAddedEvent: Object
    },
	methods: {

		getMonthAndYear(date) {
			return date.toLocaleString('en-us', {month:'long', year:'numeric'});
		},
		
		// receives -
		// used in -
		// returns - 
		hasEvent(date)  {
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
		getStartOfMonth(date) {
			return new Date(date.getFullYear(), date.getMonth(), 1, 0, 0, 0, 0);
		},
		getDateAndDay(date) {
			return  date.toLocaleString('en-us',{day:'numeric'}) + ' - ' + date.toLocaleString('en-us',{weekday:'short'});
		},
		addDays(date, days) {
			date.setDate(date.getDate() + days-1);
			return date;
		},
		sameMonth: function (currentDate, newDate) {
			// console.log(newDate);
			if(currentDate.getMonth()==newDate.getMonth()) return true;
			return false;
		},
		isWithin: function (compareDate, date1, date2)  {
			var newDate1 =  this.getDateFormat(date1); 
			var newDate2 =  this.getDateFormat(date2); 
			var newCd =  this.getDateFormat(compareDate); 
			
			return (newDate1.getTime()<=newCd.getTime() && newDate2.getTime()>=newCd.getTime());
		},
		getDateFormat (date) {
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