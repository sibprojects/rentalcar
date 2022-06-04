# RentalCar Backend Test #

Welcome to RentalCar, the fastest growing insurtech in the world.

You are landing on a new business team. This unit will develop a new platform for car rental in Barcelona.
The project is in design and discovery status, but we have been asked to create an MVP in order to prepare a demo for the global leads team in next weeks.

After long meetings, high level discussions and a lot of coffee, the product team decided that what is most important for this MVP is to show the bookings motor that we will prepare.

You will prepare the backend of this new project, you have a greenfield, there is no code, no restriction and no limits on your imagination; but as nothing comes free, you will have som minimal requisites to fulfill before the demo happens.

# User stories #
### US 1 ###
As a customer 
I want to see the availability of cars on concrete time slots
So I can be informed of pricing and stock
#### Requisites ####
* All available cars for the complete time slot will be returned.
* All cars returned will have the complete booking price, and a average day/price.


### US 2 ###
As a customer
I want to create a booking for a car
#### Requisites ####
* A user can have only one booking on the same dates.
* Driving license must be valid through all booking period.

# Our expectations #
* There is no limits here, but keep in mind that this is an MVP, not a commercial application.
* While this can take as many time as you want, we don't expect you to be working on this for 20 hours, if you feel you are not enjoying this, just write down in a .md file what you have left and how would you like to do it.
* We like to work with DDD, EDD, TDD and anything that has two "D" in its name.
* Tests should be written for at least one use case, we prefer you to finish one use case but tested than both cases without any test.
* We expect quality over quantity, SOLID, hexagonal and design patterns should be present, but don't take much more time, this is a test.
* A detailed README and documentation is needed to test and understand the app.

# How to publish this test #
* We will provide you a full week to do this test, take your time, enjoy it. If you feel you will need some more time, just tell us, we only want you to enjoy this exercise.
* The test will be a fork from the original repo and you'll get access to. Use Pull Requests and do small commits to master branch.
* If you are stuck, have any doubt or problem, don't be afraid, raise your hand and send an email to marcal.berga@bolttech.io
* Once the time has passed or you tell us that the work is finished, we will block the repository and a review meeting will be scheduled. If you deliver this exercise you will always have the review.

# Predefined values #
There are 3 main seasons:

* peak season - 1st of June to 15th of September
* mid season - 15th of September to 31st of October, 1st of March to 1st of June
* off-season - 1st of November to 1st of March

And the cars we will have in our warehouses:

| Brand | Model | Stock | Peak season price | Mid season price | Off-season price |
|---|---|---|---|---|---|
| Seat | León | 3 | 98,43 | 76,89 | 53,65 |
| Seat | Ibiza | 5 | 85,12 | 65,73 | 46,85 |
| Nissan | Qashqai | 2 | 101,46 | 82,94 | 59,87 |
| Jaguar | e-pace | 1 | 120,54 | 91,35 | 70,27 |
| Mercedes | Vito | 2 | 109,16 | 89,64 | 64,97 |