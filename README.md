# Nautal Challenge
#
![](https://cdn.nautal.com/img/nautal_logo.svg)
#
### Instructions
- In this challenge, we'll test your knowledge in architecture and best practices of software development (DDD, Hexagonal Architecture, 
  SOLID, CleanCode, DRY, KISS, YAGNI). There are many possible solutions.
- You may use the framework of your choice, however, we'd like to test your symfony knowledge so should be better if you use this framework and at version 3 or higher.
- You may use the development environment of your choice but should be better to use Docker above others.
- Document how to get this environment running and how to execute tests. 
- Comment alongside the code any relevant decisions you made during development.
- Any code you write should have tests.
- Create the project in a branch with your name and push it to the remote repository.

### Our business model

Nautal is a boat rental marketplace. We develop a platform for clients and boat owners to cover the boat rental process.
  
- On our website, we publish **Boat**, each boat has a commission assigned that gets charged to the **BoatOwner** in each rental. This 
  commission is a percentage value and can be null. In this case, we use the boatOwner default commission. Also, the **Boat** has characteristics such as length and the number of passengers allowed
  
- **Boat** boat can be registered in one or more **Port**. Each **Port** has a name and a geolocation.
  
- Our boats are registered by a **BoatOwner** identified by an email, and has other information as phone number, invoice address, 
  default commission and contact name. By default the default commission is set to 15%. 

- Every boat has **Availabilities** in each port. This are period of time the boat is available. 
  They have start date, end date and a daily rental price.
  
- A boat cannot be available in two ports at the same time. 

- When a client makes a **Request** of a boat in a port, if the boat is available, we create an **Offer**. If the boat is not available, we inform the client. 

- In the **Request**, we get the client data such as email, phone number and any comments written by the client.

- Each **Offer** is associated with one **Request**.
   
   
### Use case

- Create a REST endpoint to request a boat during a period of time in a port with the number of passengers.
  We need to gather also the client's email and phone number, and optionally he can write a comment to the boatOwner
  . The endpoint should return if the boat is available or not and, in the case that is available an offer with the price of the rental, internally we need to calculate the commission 
  Nautal needs to charge to the boatOwner in the offer.
 
- Bonus: block that availability on the boat so it is no longer available for rentals. 

### Recommendations
- It's not necessary to finish everything and leave it all working perfectly. We'll rate the architecture, best practices and understandability of your code.

- The definitions and names of entities are suggestions. You are free to design the model.

- If you have any doubts or find an error in the description of our challenge, let us know!
