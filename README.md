# Tech Support
Deployed at 
 http://webdev.bentley.edu/teisenhut/tech_support3


Technologies Used: SQL, PHP, HTML, CSS, MySQL workbench, Filezilla.

12/21/2022


Overview: 

The SportsPro Technical Support application is a multi-use case website that was desinged for a business to manage Tech Support cases. Depending on log in credentials, a user could be an admin with unlimitted access, a technician with limkited access or a customer with the most restricted access to the site. Administrators can perform functions such as maintaining the Products, Customers, and Technicians tables of the tech_support database. Technicians can perform functions such as updating incidents and Customers perform functions such as registering products. This application runs using a connection to a SQL database, tech_support, which is used to track technical support incidents. This database contains 7 interconnected tables that can be modeled with this domain model:

![Screenshot 2023-06-13 at 7 56 33 PM](https://github.com/tannere7/Tech_Support/assets/107820917/863b67dd-32e8-431f-a9c5-78e2f552f588)

Proper security techniques had to be implemented to ensure that SQL injection errors could not occur and that access rights were limited based on user log in.


Developed for CS360 course at Bentley University.
