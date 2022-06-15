Hello,

Here is the front end usage explaining as a screen capturing Youtube video link
>>
[Front End Description]
-----------------------
https://www.youtube.com/watch?v=f24KFyUyrHY

[Backend Description]
-------------------------
https://www.youtube.com/watch?v=oZqgsN_o23E

>>
This project is based on the given task for an interview job postion in laravel,
This project has simple two tables for crud operation and authentication which is created in migration folder.
-  Brief Explanation:
This test laravel project is developed according the custom request from an  employee to check my code structure and logics.
Here I have developed the tasks using Laravel frameworks since its highly customizable with all pre-developed libraries which really makes the developer as an artisan in software developement. All the backend codes are abstracted using repository and service logic in order to make the codes highly loosly decoupled. So once you make changes or use another technologies, the rest of codes are not affected.

Qustions:
1. Setup a project having APIs & frontend separately.
- Reply: This is being done, since if you check the backend all the codes are in proper way which the logic with implementation is separated using repository and services, where then the repository is binded with the interfaces in order to make the code more decoupled. Any time if you have any business logic you just bring the changes in the services, that is it. So all the backend created codes are re-usable.

2. On the front-end there should be a sign-in & sign-up page.
- reply: Login and signup of the laravel it self is used here, since we dont have to re-code here, but a little customization is done for the registration. 


3. After sign-up the system should send a welcome email to the user along with a randomly generated password to login on the system later on. You can use any preferred method for sending emails.
- Reply: This has been figured out creating a mailable class with the dummy welcome template inserting the required information, Here I have used mailtrap.io which is set in the .env file. I have created an account in mailtrap in order to check and test locally.

4. On successful login, there should be a simple dashboard showing the number of registered cars in your system.
- Reply: The syste will show the vehicle lists after successful login.

5. Make a CRUD for categories e.g. Bus, Sedan, SUV, Hatchback etc.
- Reply: The CRUD operation for the category lookup table is completed both for API and web request.

6. Make a CRUD for Cars where the user can select one of the categories from the dropdown & can have other fields like color, model, make, registration-no etc.
- Reply: The CRUD operation for the vehicle part is also done, since there we have only 2 table  categories and vehicles which the category is having multiple vehicle records (Parent-child relation ship or one to many).

7. Must use data-tables for sorting & pagination.
- Reply: data-tables plugin is used in the front end section to show the list appropriately since it has many functionality for the ease of the end user.

8. Your system should be protected XSS & should have implemented JWT.
- Reply: XSS (Cross Site Scripting) is taken into consideration creating a XssSanitazion middleware in order to stripe all inputs which are coming as a request from the user, so both in API, and web request its just implemented and used in routes (web and api).


9. Each create & update module must have both front-end & back-end data validation.
- Reply:  Both  API and web based requests are validated, since in API we may have multiple methods like partial updating fields, thus its set in custom request file.
