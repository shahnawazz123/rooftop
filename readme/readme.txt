


Run rooftop.sql 
List of apis -
	1:I want to see which coaches I can schedule with.
		API- http://localhost:8080/api/schedule-coaches
		Method- Get

	2:I want to see what 30-minute time slots are available to schedule with a particular coach.
		API- http://localhost:8080/api/current-coaches
		Method- Get

	3:I want to book an appointment with a coach at one of their available times.
		API- http://localhost:8080/api/available-coaches?available_time=09:00:00
		Method- Get
		Params- available_time

Note: all coaches show on user local time and day;		