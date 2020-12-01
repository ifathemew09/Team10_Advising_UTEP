# Team10_Advising_UTEP
CS 4342 Database Management Project


We will develop an Advising system for the Computer Science Department to aid in managing advising from the Admin, Advisor, and Student perspective. The system will authenticate the following classes of users: Student, Advisor, and Admin. The system will store advising documents the student has provided, such as: Degree Plans, Flowchart, Academic Advising Form, etc. The system will check a student's classification before scheduling a meeting with the advisor. The system shall keep track of probationary status and any change of advisors.  

 
The admin will be authenticated in order to access the system. They will manage the creation and deletion of Advisors and Students in the system. The admin will have a unique admin ID, a name (first name, middle name, and last name), utep email address, and a password. The admin will have access to remove holds for a student after receiving confirmation from the advisor. The admin will provide the advisor a list of students to be advised. The admin can leave notes on any student in the Computer Science department.
 
 
The advisor will be authenticated in order to access the system. They will have a unique advisor ID, a name(first name, middle name, last name), a UTEP email address, and a password. The advisor will be able to fill out the advising form of their assigned student(s), will have a list of students they will advise, and access the student’s academic profile to make comments about any notes that were taken during the appointment. 
 
 
The student will be authenticated in order to access the system. The student will have a unique Student ID, a name (first name, middle name, last name), a UTEP email address, a password, and their classification. They will have a personal profile on the system that will have their full name, email address, and their UTEP ID. The student will be allowed to request an appointment for a preferred time and cancel an appointment 24-hours prior to the meeting. 
 
 
The system will store all of the following information in a database and manage displaying data to the advisor, admin, and student. The system will allow the administrator to accept and decline schedule requests from students and handle duplicate requests or an already approved schedule  that contains the same date and time for an appointment. The system will also give the admin the access to create and remove advisors and students from the system, if needed. 
