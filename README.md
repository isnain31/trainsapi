snubesapi
=========

A Symfony project that uses symfony in the backend and angularJS in the front end to insert/update/delete trains in a train station and calculates the number of track needed in day to service all trans scheduled to come.

How to use:
===========

* clone the repository

* run composer install 

* create and migrate database migration files are given

* optional: create a virtual host


Front end
=========

* the directory "frontend" has the fonrend part. 

* On first run in the settings panel put the api url

* in case of wrong api url entered at the first time just refresh the page



Disclaimer
==========
The application runs well in firefox and chrome. However it was not tested in IE



api docs (optional reading)
===========================

GET /trains: gets all trains 

GET /train/id: gets one train

POST /train/add josn data: saves a train 

PUT /train/edit josn data: updates a train 

DELETE /train/id: delets one train

josn data must contain:
	trainName,buildYear,trainType

trainnumber will be generated and returned back during addition



