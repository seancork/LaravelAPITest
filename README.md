# LaravelAPITest (Laravel 8)

An API endpoint that gets a csv file with columns name and age. Returns a JSON response with a breakdown of all the ages that were duplicated and the percentage of rows that had the same age.

## How to use

Example:
- Download postman
- Post Route: /api/csv
- Send csv file to the above api route

Feature Tests:
- Validation for file not included with post request
- Check for correct data return and correct response (201)
### Example input:
 
```
Name,age
John,2
Jim,25
Jack,20
Tom,19
Joe,20
Ellen,25
Mary,2
Tim ,2
Kim,6
``` 


### Example output:
``` 
[{"age":2,"dups":3,"precentage":33.33333333333333},
{"age":25,"dups":2,"precentage":22.22222222222222},
{"age":20,"dups":2,"precentage":22.22222222222222}]
``` 
