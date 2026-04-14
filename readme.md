#NEMC Student Management System

## Requirements

- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- BCMath PHP Extension

## Installation

- Clone the project first

- Pull the docker image if you don't have  
  *`docker pull aashakib/lara-container-php7.2`*

- Dockerize your project.Run this command  
  *`docker run -p YOUR_PORT:80 --name nemc -d -v APP_PATH:/var/www/html/app aashakib/lara-container-php7.2`*

- Go inside your container  
  *`docker exec -it nemc bash`*

- Run these commands  
    *`composer install`*  
    *`php artisan key:generate`*  
    *`php artisan migrate`*  
    *`php artisan db:seed`*

- Set Write permission to  
    *`sudo chmod -R 777 bootsrap/cache`*  
    *`sudo chmod -R 777 storage`*
    
- Cronjob Setup  
    *Open crontab and add* `0 1 * * * cd /var/www/html/app && php artisan schedule:run >> /dev/null 2>&1`
    
- Supervisor Setup  
    - open /etc/supervisor/conf.d/supervisord.conf in any editor. (example: `nano /etc/supervisor/conf.d/supervisord.conf`)
    - add at the bottom of this file  
    `[program:laravel-worker]`  
    `process_name=%(program_name)s_%(process_num)02d`  
    `command=php /var/www/html/app/artisan queue:work --sleep=5 --tries=3`  
     `autostart=true`  
     `autorestart=true`  
     `numprocs=8`  
     `redirect_stderr=true`  
     `stdout_logfile=/var/www/html/app/storage/logs/worker.log`   
     - `sudo supervisorctl reread`  
     - `sudo supervisorctl update`  
     - `sudo supervisorctl start laravel-worker:*` 
    

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Module Introduce
We followed the laravel naming convention almost in all modules for Example create something in controller's create method, save data to store method etc. We also written all the business logic in respective module's service. 

## Settings Module
The *`Settings`* module has good number of submodules and these submodules work as configurable module for the hole application, so let's discuss about these one by one first.
- Application Settings:
    This module holes the basic information about application. For example , application name, email, contact number etc.
     - `Show basic information of application`  
     Application basic information has been added by seeder called *`ApplicationSettingTableSeeder`*  to *`application_settings`* table.
     - `Edit Application Information`  
     Application information is Updated in *`ApplicationSettingController`* 
     - `Remarks:` 
     In future, this application information will be used for different purpose. 
     
- Course:
    Course is the key part of a session(will talk about session later). From this submodule we can manage course for a session. 
    Here, we have two courses called *`MBBS`* and *`BDS`*.
     - `Create`  
      To create couese we used *`CourseController`*  
     - `Edit & Update`  
     Also used *`CourseController`*  to edit & update the course information
     - `Remarks:` 
     Later, we will use this course information for different purpose in many modules. 
     
- Phase:
    A phase is a professional Duration of 1-1.5 years for a course in a session. A course has 4 phases.
     - `Create`  
      To create phase we used *`PhaseController`*  
     - `Edit & Update`  
     Also used *`PhaseController`*  to edit & update the phase information.
     
- Term:
   Every phase has 2-3 terms so phase consist with terms. Every single term has 6 months duration.Term is treated as a single time duration of a phase and 2-3 terms makes a phase.
     - `Create`  
      To create terms we used *`TermController`*  
     - `Edit & Update`  
     Also used *`TermController`*  to edit & update the terms information. 
     
- Department:
   A department is responsible for teaching department related subject. Single course has many departments. We can manage department from this submodule. 
   Every department has a department head. This department submodule has relation with *`users`* submodule and department head list come from *`users`* submodule.
     - `Create`  
      To create department we used *`DepartmentController`*.
     - `Edit & Update`  
     Also used *`DepartmentController`*  to edit & update the department information.

- Designation:
    Designation submodule deals with designation or post for different persons. Every designation also has a organizational order. 
    According to designation, a person plays his role to the organization.
     - `Create`  
      To create designation we used *`DesignationController`*.
     - `Edit & Update`  
     Also used *`DesignationController`*  to edit & update the designation information.
     
- Class Type:
    Class Type means category of class such as lecture, practical etc. To generate class routine for a subject, we need class type.
     - `Create`  
       To create class Type we used *`ClassTypeController`*.
     - `Edit & Update`  
       Also used *`ClassTypeController`*  to edit & update the class Type information.
     - `Remarks:` 
     In future, class type will be used for different purpose such as class routine, exam etc.
- Class Room:
    In class room submodule, class room will be configured for every floor, To create class room, need to mention floor number of academic building.
    As we know about floor number so floor number is generated form *`UtilityServices`*.
     - `Create`  
       To create class room we used *`HallController`*.
     - `Edit & Update`  
       Also used *`HallController`*  to edit & update the class Room information.
     - `Remarks:` 
     In future, class room will be used to generate class routine schedule. We will mention class room to arrange a class white create class routine.
     
- Student Category:
    Student category is created in this submodule. The main purpose of student category is add every student under a student category. Here category indicates normal, poor, foreign etc student. We also need category of a student for development fee generation.
     - `Create`  
           To create student category we used *`StudentCategoryController`*.
     - `Edit & Update`  
           Also used *`StudentCategoryController`*  to edit & update the student category information.
     - `Remarks:` 
            In future,  Student category will be used during admission and student creation as well as fee generation.

- Student Group:
    Student group will be used for class routine generation and exam setup. 
    Basically we need student group for practical class because practical is arranged for a group of students.
     - `Create`  
           To create student group we use *`StudentGroupController`*. For every student group creation we need to provide
           *`group type`* forExample 'exam & class', 'visit' or clinic. Group types are get from *`UtilityServices`* . Also need to provide range of student roll for a student group.
     - `Edit & Update`  
           Also used *`StudentCategoryController`*  to edit & update the student group information.
     - `Remarks:` 
            In future,  Student group will be used during class routine generation and exam setup.
            
- Education Board:
    This submodule shows the list of education board in a country. Main purpose of this submodule is to generate education board and this 
    education board will be used during the addition of education information of applicant or student in *`Admission`* and *`Student Management`*  modules.
     - `Create`  
          To create Education Board we used *`EducationBoardController`*.
     - `Edit & Update`  
          Also used *`EducationBoardController`*  to edit & update the education Board information.

- Attachment Type:
    In different modules and submodules we need to upload different attachment such as passport, academic documents, visa etc. 
    When upload any attachment then we have to mention the type of that attachment. So this submodule works with attachment type
     - `Create`  
          To create Attachment Type we used *`AttachmentController`*.
     - `Edit & Update`  
          Also used *`AttachmentController`*  to edit & update the Attachment Type information.
     - `Remarks:` 
          When need to upload any attachment then attachment type will be used. ForExample student, applicant academic information upload.

- Payment Type:
    Payment type submodule deals with the type of payments. Every student have to pay money in different category in his/her academic life such as 'development fee', 'tuition fee', 'class absent fee' etc.
    In this submodule we just create the types of payments. 
     - `Create`  
          To create Payment Type we used *`PaymentTypeController`*.
     - `Edit & Update`  
          Also used *`PaymentTypeController`*  to edit & update the Payment Type information.
     - `Remarks:` 
          Payment type will be use when generate fee, collect fee etc.

- Bank:
    This submodule shows all bank list. Initially we used *`BankTableSeeder`* to add available bank to database but we also can add and edit further bank to this submodule. 
     - `Create`  
          To create Bank we used *`BankController`*.
     - `Edit & Update`  
          Also used *`BankController`*  to edit & update the Bank information.
     - `Remarks:` 
          When fee will be taken from students then bank will be mention against a payment. 

- Payment Method:
     Here payment method means which process student use to pay his payment such as 'Check', 'Cash on NEMC' etc
     - `Create`  
          To create Payment Method we used *`PaymentMethodController`*.
     - `Edit & Update`  
          Also used *`PaymentMethodController`*  to edit & update the Payment Method information.
     - `Remarks:` 
          When student pay bills then payment method will be mentioned.

- Payment detail:
    We know about *`Payment Type`* submodule which has 6 types of payment. Now, this submodule configures every *`payment type`* amount such as tuition fee amount, Development fee amount etc. 
    
     - `Create`  
          To configure *`Payment Type`* amount we used *`PaymentDetailController`*. We also used *`Payment Type`*, *`student Category`* , *`course`* submodule for relational information.
     - `Edit & Update`  
          Also used *`PaymentDetailController`*  to edit & update the *`Payment Type`* amount and other information.
     - `Remarks:` 
          Amount of every *`Payment Type`* will be use for student according to their *`student Category`* and *`course`*. For example, development(*`Payment Type`*) fee of a normal(*`student Category`*) student is 1800000.00tk.


## User Management Module
This module manages users and their access in the application. To ensure access of user, first we create *`user Group`* such as 'Super Admin', 'Admin', 'Teacher', 'Student' etc from *`user Group`* submodule. Then assign permission to every *`user Group`* and
finally assign a user under a *`user Group`*. By doing this we can manage user's access permission to the application.  

- User Groups:
     This submodule deals with 'user group' and 'user group' permission
     - `Create`  
          To create user group we used *`UserGroupsController`*.
     - `Edit & Update`  
          We also used *`UserGroupsController`*  to edit & update the 'User Group' information.
     - `Permission`  
               Initially user group permissions are provided by *`UserGroupPermissionsTableSeeder`*. You can see 'user group' wise permission by clicking on 'setting button' from list page and you get this form *`permission`* method of *`UserGroupsController`*. Permission can be edit/update from *`updatePermission`* method of same controller.
     - `Remarks:` 
          There is a relationship between *`User Group`* and *`User Group Permission`*. Main purpose of this relationship is to control access permission of a *`User Group`* in different modules and submodules in the application.
     

- Users:
     This submodule shows all the user already created. To add or edit user we used 3 relational submodules these are *`User Group`*, *`Department`* and *`Designation`*. 
     During user creation, data is stored in two tables *`users`* and *`admin_users`*. 
     Basic information will be stored in *`users`* table and detail information in *`admin_users`* table.
     - `Create`  
          To create User we used *`UsersController`*.
     - `Edit & Update`  
          Also used *`UsersController`*  to edit & update the user information.
     - `Remarks:` 
          By assigning a user under a *`User Group`* we can limit or control user access in modules and submodules in application.          
          
## Subjects Module
This module talks about all the things related to subject such as *`Topics`*, *`Items`*, *`Cards`*, *`Books`* etc and their roles.

- Subject Group:
    For application purpose we need to assign every subject under a subject group. Subject group will be created under *`Course`*.
     - `Create`  
          To create 'subject group' we used *`SubjectGroupController`*. The relational course comes from *`Course`* submodule.
     - `Edit & Update`  
          We also used *`SubjectGroupController`*  to edit & update the 'subject group' information.
          
- Subject:
     All subjects can be manage in this submodule. There are 1 more subject with same name as a result we place every subject under a subject group so that we can identify every subject uniquely.
     This submodule also has relation with *`Department`* and *`Exam Sub Type`*. Now summary are, we create a subject under a *`subject group`* and *`Department`* at the same time we attach *`Exam Sub Type`*. 
     *`Exam Sub Type`* will de describe later, just keep in mind that this will be used when we setup exam.
     - `Create`  
          To create 'subject' we used *`SubjectController`*. The relational 'subject group', 'department' and 'exam sub types' come correspondingly from *`subject group`* , *`Department`* and *`Exam Sub Type`* modules.
     - `Edit & Update`  
          We also used *`SubjectController`*  to edit & update the 'subject' information.
     - `View`  
      We can see details of a subject and it's related information from *`SubjectController`* .
      
- Topic Head:
    The main purpose of *`Topic Head`*  and *`Topics`* submodules are to attach topics to subject, to do that our 1st target is to attach *`Topics`*  under *`Topic Head`*.
    
     - `Create`  
          To create 'Topic Head' we used *`TopicHeadController`*. The relational subject comes from *`subjects`* submodule. 
          That means every *`Topic Head`* will be created under a subject.
     - `Edit & Update`
          We also used *`TopicHeadController`*  to edit & update the 'Topic Head' information.
     - `View`  
      We can see details of a Topic Head and related information attached with it such as topics and subject information from *`TopicHeadController`* .
      
- Topics:
     This submodule also has relation with *`Topic Head`*. Every topic will be created under 'Topic Head'. 'Topic Head' comes from *`Topic Head`* submodule. Topic can be assign to teacher from 'Topic edit'.
     - `Create`  
          To create 'Topic' we used *`TopicController`*.
     - `Edit & Update`  
          We also used *`TopicController`*  to edit & update the 'topic' information.
     - `Assign Topic To Teacher`  
      Topics can be assign from function *`assignTopicToTeacher`* in *`TopicController`*. 
      Click on 'Assign Topic' button from *`Topics`* submodule list page. then filter topic by subject and select teacher to whom you want to assign topic. 
      Finally check topics checkbox and hit on save button. The selected topics will be assign to selected teacher.
      Here teaches list comes from *`Teacher`* module.

- Cards:
     Card and Item both submodules are related to exam. We will see the relationship later when talk about exam.
     Every 'Card' will be create under *`Subject`*, *`Phase`* and *`Term`* submodule, these relational data come from respective submodules.
     - `Create`  
          To create 'Cars' we used *`CardController`*.
     - `Edit & Update`  
          We also used *`CardController`*  to edit & update the 'Card' information.
     - `View`  
      We can see card details and all 'Items(discuss below)' list related to this card.
      
- Items:
     Item is related to *`Cards`* submodule. Here every item will be created under a 'Card'. Here related cards are coming from *`Cards`* submodule.
     - `Create`  
          To create and save 'Item' we used functions *`createCardItems`* and *`saveCardItems`* from *`CardController`*.
     - `Edit & Update`  
          We also used functions *`editCardItems`* and *`updateCardItems`* from *`CardController`* to update 'Item' information.
     - `Item Exam`  
      We can create or configure Item Exam by clicking on 'Exam' button from list page. 
      After filtering by required value you will get all student and Item Exam configuration environment.
      
- Books:
     The main purpose of this submodule is to suggest books for any subject to students. Every book will be created under a subject. We get subject list from *`Subject`* submodule.
     - `Create`  
          To create we used *`SubjectController`*.
     - `Edit & Update`  
          We also used *`SubjectController`*  to edit & update the 'Book' information.
      
## Teacher Module
- Teacher:
    This module deals with teacher. Here, every teacher has relationship with *`Course`*, *`Department`* and *`Designation`*. 
    The relational data comes from submodules *`Course`*, *`Department`* and *`Designation`*. A teacher also can reset his/her password from this module.
 
     - `Create`  
          To create teacher we used *`TeacherController`*. When create a teacher then data insert into two tables. Where basic information such as email, username, etc insert into *`users`* table and details information is stored to  *`teachers`* table.
     - `Edit & Update`  
          We also used *`TeacherController`*  to edit & update the teacher information. During update teacher, data also update into *`users`* and *`teachers`* table.
     - `Reset Password`  
          From teacher list page admin and teacher can change teacher's password. This is also done by *`changePassword`* method in *`TeacherController`*.
          
                
## Examinations Module
  In this module, we can configure exam for any subject, Then provide marks to student as student obtained in exam and finally we can publish exam result.

- Exam Category:
    Exam category is managed by this submodule. To configure exam we need exam category. Here exam categories are 'Professional', 'Card', 'Assessment' etc.
 
     - `Create`  
          To create exam category we used *`ExamController`*.
     - `Edit & Update`  
          We also used *`ExamController`*  to edit & update the exam category information.
     - `Remarks:` 
          When we configure *`Exam Setup`* then we will use exam category.

-  Exam Type:
    Every *`Exam Sub Type`* will be create under *`Exam Type`*. So we need to crete exam type first.
    Here exam type indicated 'Clinical', 'Practical', 'MCQ' etc.
 
     - `Create`  
          To create exam type we used *`ExamTypeController`*.
     - `Edit & Update`  
          We also used *`ExamTypeController`*  to edit & update the exam type information.
     - `Remarks:` 
          We will use exam type to create *`Exam Sub Type`*

-  Exam Sub Type:
    Exam sub type has relation with *`Exam Type`*. Every exam sub type will be create under a *`Exam Type`*. 
    The main purpose of *`Exam sub Type`*  is when create subjects from *`subject`* submodule then we will attach exam sub types with subject.
     - `Create`  
          To create exam sub type we used *`ExamSubTypeController`*.
     - `Edit & Update`  
          We also used *`ExamSubTypeController`*  to edit & update the exam sub type information.
          
-  Exam Setup:
    In this submodule, we setup exam configuration for a subject. This module has relationship with module *`sessions`* and submodules
    *`Course`*, *`Phase`*, *`Term`*, *`Exam Categoty`*, *`Batch`*, *`Exam Group`* and *`Exam Type`*.
    
    - `Create`  
              To create exam we used *`createExam`* and *`saveExam`* methods in *`ExamController`*. In exam create form,
              first provide basic information with exam category. Now add subject for thom you want to setup exam. 
              For every exam of a subject, need to select exam type(written or practical). If exam type is practical then need to configure 
              practical exam group. Here every group made of 'Exam Sub Type', 'Student Group' and 'Exam date'. Finally, created exam
              will be shown in the list page.
    - `Edit & Update`  
          We also used *`editExam`* and *`updateExam`* methods in *`ExamController`*  to edit & update the exam information.
          
    - `View`  
             We used *`getExamDetail`* method in  *`ExamController`* to see details of created exam.
             
    - `Setup Exam Marks`  
             Let already we have created an exam,  now we need to setup marks for that exam. To do this, click on 'Marks Setup' button from list page and you will move to mark setup page.
             provide marks and hit on save button. Marks configuration are done.
    - `Remarks:` 
          In this submodule we just setup exam for subject and also setup marks for the exam. 
          In the below module we will provide marks to all student according to their obtained marks in the exam.
    
-  Exam Result:
    In this submodule we will provide marks to students and publish the exam result. This module has relation with
    *`sessions`*, *`Course`*, *`Phase`*, *`Term`*, *`Exam Categoty`* and *`Teacher`*.
    
    - `Publish Exam Result`
         Click on 'Publish Exam Result' button from list page. Filter the subject by exam to provide marks to students. You get the marks distribution table according to exam setup(done in *`Exam Setup`*). 
         Now provide marks. Again to publish the result please check the checkbox called 'Publish result for this subject?'. 
         Press on save button, result will be save and publish. If don't want to publish result then keep the
          checkbox (Publish result for this subject?) uncheck. Your result will be save to database. To publish the saved exam result, please filter the exam from list page and go to edit mode, now check the checkbox called 'Publish result for this subject?' hit on save button. 
          Result will be publish. We used *`ResultController`* to save and publish the exam result. 
    
    
## Session Management Module
- Session Management:
    Session is the core thing of the application. When a session will be create then major things related to session are covered such as phase, term, exam, subject and different fees etc.
    When we create/update session then data insert/update into 4 tables, these are *`sessions`*, *`session_details`*, *`session_phase_details`* and *`session_phase_detail_subjects`*.
    During session creation we have to provide data carefully for courses 'MBBS' and 'BDS'. Session has relational data such as phase, subject. Phase and subject related data comes from *`Phase`* and  *`Subject`* submodules'
 
     - `Create`  
          To create session we used *`SessionController`*.
     - `Edit & Update`  
          We also used *`SessionController`*  to edit & update the session information.
     - `View`  
          We also used *`SessionController`*  to show details of session information.
     - `Clone Session`  
          To clone a session just click on 'clone session' button from session list page and chane necessary field you need.
          We used methods *`cloneSession`* and *`saveCloneSessionData`* in *`SessionController`* to complete cloning a session. 
           *`SessionController`*  to edit & update the session information.
     - `Remarks`  
          Session data will be used almost in every modules or submodules.
          
          
## Admission Module

- Applicants:
    This submodule deals with applicant registration. During registration of a applicant to application there is some relational submodules such as 
    *`sessions`*, *`courses`*, *`studentCategories`*, *`countries`*, *`certifications`*, *`educationBoards`*, *`attachmentTypes`*. The relational data comes from respective submodules except *`certifications`*. *`certifications`* comes from *`UtilityServices`*.
    When we create/edit an applicant then applicant data insert/update into 4 tables. These are *`admission_parents`*, *`admission_students`*, *`admission_emergency_contacts`*, *`admission_attachments`*.
     Now,
  
     - `Create`  
          To create applicant we used *`AdmissionController`*. When we submit form then applicant data inserted to the above mentioned tables.
     - `Edit & Update`  
          We also used *`AdmissionController`* to edit & update the applicant information.
     - `View`  
          We also used *`AdmissionController`* to show details of applicant information.
     - `Selection For admission`  
          After completing registration of a applicant go to edit and change applicant status to 'Selected for admission'. Now applicant is ready to migrate into student.
          We also can change applicant status by clicking on "Update Status" button from applicant list page.
     - `Transfer to Student`  
         After changing applicant status to 'Selected for admission' go to applicant list page click on "Transfer to Student" button. Then student's username and password etc will be generated and applicant information will be inserted to new tables as student information.
         These tables are *`users`*, *`students`*, *`student_fees`*, *`student_fee_details`*, *`emergency_contacts`*, *`education_histories`*, *`attachments`*. These operations handle by *`transferStudentData`* method in *`AdmissionController`*.
         
     - `Email Conformation about registration`  
         After successful transformation of applicant to student, student and his father will get a account confirmation email with 'User ID' and 'Password'. 
     
     - `Remarks`  
         When applicant is migrated to student then all activities regarding student starts. Migrated student's different fees start to generate. Here fees are 'development fee', 'tuition fee', 'class absent fee' etc.
 
         
## Student Management Module
- Student Management:
    In the *`Admission`* module we see that an applicant is transferred to student by completing some steps.
    This module shows the list of student came from applicant. Again there is another purpose behind this module.
    That is, if authority want they can directly register a student to *`Student Management`* module without facing *`Admission`* module.
    
    During registration of a student to application there is some relational module and submodules such as 
    *`sessions`*, *`courses`*, *`studentCategories`*, *`countries`*, *`certifications`*, *`educationBoards`*, *`attachmentTypes`*. The relational data comes from respective submodules except *`certifications`*. *`certifications`* comes from *`UtilityServices`*.
    When we create/edit an applicant then applicant data insert/update into 8 tables. These are *`users`*, *`guardians`*, *`students`*, *`emergency_contacts`*,  *`education_histories`*, *`attachments`*, *`student_fees`*, *`student_fee_details`*.
     Now,
  
     - `Create`  
          To create student we used *`StudentController`*. When we submit form then student data inserted to the above mentioned tables.
     - `Edit & Update`  
          We also used *`StudentController`* to edit & update the student's information.
     - `View`  
          We also used *`StudentController`* to show details of student information.
     - `Viw, download, delete and add attachment`
          By clicking on 'Attachment' button from student list page one can add, delete, download student attachments. Attachment add , save and delete are handle by respective methods *`addAttachment`*, *`saveAttachments`*, *`deleteAttachment`* in *`StudentController`*.
         
     - `Installments`  
           Let's first introduce with Installments. Installment means a sum of money paid in small parts in a fixed period of time. When a student register then development fee generated for that student. 
           student can paid the development fee amount in single installment but if he wants to pay the fee amount in multiple installment then he can do this.
           To edit installment click on 'Installments' button from student list page. Now click on 'Edit Installment' button. One can chose the number of installment.
           Installment information storage is handled by *`saveInstallments`* method in *`StudentController`*.   
     
     - `Reset Password`  
           From student list page admin and student can change student's password. This is also done by *`changePassword`* method in *`StudentController`*.
           
     - `Send Message`  
          By clicking on message button from student list page, admin and student can send message to each other. This operation is done by *`MessageController`*. When message form is submitted then data is inserted into two tables,  these are *`messages`* and *`notifications`*.
          
          
## Parent Management Module
- Parent Management:
   In this module parents come from *`Admission`* module, when an applicant transfer to student and when a student directly resister to student module then applicant's and student's parent's information stored into *`guardians`* table.
   And parent list come from *`guardians`* table. As a result don't need to create parent.
     - `Edit & Update`  
          We also used *`GuardianController`* to edit & update the parent's information.
     - `View`  
          We also used *`GuardianController`* to show details of parent information and parent student(child).
    
     - `Reset Password`  
           From parent list page admin and parent can change parent's password. This is also done by *`changePassword`* method in *`GuardianController`*.
           
     - `Send Message`  
          By clicking on message button from parent list page, admin and parent can send message to each other. This operation is done by *`MessageController`*. When message form is submitted then data is inserted into two tables,  these are *`messages`* and *`notifications`*.
          
          
## Holiday Module
- Holiday:
    Holidays can be created from this module. Every holiday has relationship with *`sessions`* module and *`batchTypes`*. The relational data come from respective module and submodule.
    During holiday creation, if we select 'session' and 'batch type' then holiday creation notification send to all student of selected batch of selected session. If select only 'session' then notification will be send to students of selected session.
    If don't select session as well as batch type then notification will be send to all users.       
    
    - `Create`  
          To create holiday' we used *`HolidayController`*.
    - `Edit & Update`  
          We also used *`HolidayController`* to edit and update holiday information.
    - `View`  
          We also used *`HolidayController`* to show details of holiday information.
    - `Calender View`  
          We also used *`getCalendar`* method of *`HolidayController`* for holiday calender view.
          
## Notice Board Module
- Notice:
    This module manages any notice regarding institute. Every notice has relationship with *`sessions`* and *`batchTypes`*. The relational data come from respective module and submodule.
        During notice creation, if we select 'session' and 'batch type' then notice creation notification send to all student of selected batch of selected session. If select only 'session' then notification will be send to students of selected session.
        If don't select session as well as batch type then notification will be send to all users.      
    
    - `Create`  
          To create notice' we used *`NoticeBoardController`*.
    - `Edit & Update`  
          We also used *`NoticeBoardController`* to edit and update notice information.
    - `View`  
          We also used *`NoticeBoardController`* to show details of notice information.
          
    - `Remarks`  
          If you become agree to publish notice by checking checkbox then notice notification will be send to user. But if don't agree, then notice will be created and notice's notification don't send to user.
          
          
## Academic Calendar Module
- Academic Calendar:
    In academic calender one can generate *`Holiday List`*, *`Class Routine List`*, *`Exam List`*, *`Book List`* for a session and course. The main purpose of this module is to display basic information of a course in a single platform.
    User also can download the mentioned information in pdf file.
    
## Message Module
- Message:
    In the application different users such as student, teacher etc can send message to each other. All the messages can be show in message module and user also can reply against the message send to him/her.
    To get message list *`MessageController`* is used. To reply message just click on 'view' button and leave reply for message.
    To store reply of a message we used *`saveReplyMessage`* method in *`MessageController`*.
    - `Remarks`
        Different user can communicate with each other through this module.
    
          
    
          
## Class Routine Module
This module deals with student class routine or schedule. Using this module we can create/update class routine for a term. Also can see the number of classes for a term.
For every single class teacher can upload lecture material and provide attendance. User also can see the class routines in calender view. Class routine can be generated for practical class also.
When you create class routine for practical class then you need to assign teacher for every student group. 


- Class Routine:
     To generate class routine for a term of a phase there is some relational modules and submodules, these are *`session`*, *`classTypes`*, *`batchTypes`*, *`classRooms`*, 
      *`classDays`*, *`studentGroups`*. *`studentGroups`*  will be used for practical type class such as 'Tutorial', 'Histology', 'Dissection' etc.
      
     - `Create`  
          To create class routine we used *`ClassRoutineController`*.
     - `Edit & Update`  
          We also used *`ClassRoutineController`*  to edit & update the class routine information.
          
     - `View`  
          We also used *`ClassRoutineController`* to show all the classes for a term.
          - `Single Class Edit & Update`  
               We used *`editIndividualClassRoutine`* and *`updateIndividualClassRoutine`* methods in *`ClassRoutineController`*  to edit & update every single class routine information.
               
          - `Single Class view`  
               By clicking on 'view' button you can see the basic information of a single class routine, we used *`getIndividualClassDetail`* method in *`ClassRoutineController`*  for that.
               you also can upload *`Lecture Materials`*, provide *`Student's Attendance`* and filter attendance.
               
     

- Class Routine Calendar:
     From this submodule one can see the class routines in calender view. This operation is handles by *`getCalendar`* method in *`ClassRoutineController`*. 
     You also can filter you desire class routine form here.
     
     

# Payment Module
- Generate Fee:
    From this submodule we can see 3 types of fee information of a student. The fee types are 'Class Absent Fee',
    'Development Fee' and 'Tuition Fee'. To see the fee information you have to filter by fee and student information.
    
    - `Edit & Update`  
          We used *`editSingleStudentFee`* and *`updateSingleStudentFee`* methods from *`PaymentController`* to edit and update fee information.
          In edit mood, only discount can be given against student fee amount . If you give discount, then you have to attach discount application file also.
          For 'Development fee' the process are little bit difference. After filtering, first click on 'view' button to move detail page. Now edit the 'development fee', you only can give discount against a fee amount. 
          Again, if you give discount on a fee amount you have to attach 'discount application' file and this operation is handled by 
          *`editSingleInstallmentOfDevelopmentFee`* and *`updateSingleInstallmentOfDevelopmentFee`* methods in *`PaymentController`*.
    - `View`  
          We also used *`showSingleStudentFee`* method in *`PaymentController`* to show details of a fee information.
          
    - `Remarks`  
          From this submodule one can see student's fee details and give discount on fee amount.
          
- Generate Tuition Fee:
    This submodule helps to generate student's old tuition fee. You can see the tuition fee information of your desired student by filtering from list page.
    Now, you can click on 'Generate Old Tuition Fee' button to generate tuition fee for month range, such as 2, 5 month.
    
    - `Create`  
          To generate old tuition fee we used *`generateStudentTuitionFee`* and *`saveStudentTuitionFee`* in *`PaymentController`*. 
          There are *`session`* module and *`course`* submodule relational data. Just provide date range to generate tuition fee. 
          If you don't provide 'end date' in date range then tuition fee will be generated for all the month where tuition fee not generated yet.
    
    - `Remarks`  
          You can provide discount and see details of tuition fee from list page on filtered data.
   
- Collect Fee:
    In the previous submodules we talked about different fee generation but now in this submodule we collect different fee amount from student. 
    From list page you can get information about different fee by filtering your desired student's data. Finally click on 'Collect Fee' button to move fee collection page.
    To collect fee there is some relational module and submodules these are *`sessions`*, *`courses`*, *`paymentTypes`*, *`paymentMethods`*, and *`banks`*
    
    - `Create`  
          To collect fee we used *`studentFeeCollectForm`* and *`saveStudentPaymentData`* in *`PaymentController`*. 
          Collected fee amount will be balanced from main fee amount.
    
    - `Remarks`  
          If a student paid more amount than his total payable amount then extra amount will be stored as his credit amount and future fee will be taken from credit amount.
          
- Student Payment:
   After collecting fee from student. The pain amount information can be shown in list page by filtering with student data.
    
    - `Edit & Update`  
          Student payment can be edit and update by these methods *`studentPaymentEdit`* and *`studentPaymentUpdate`* in *`PaymentController`*. Here you can not edit paid amount because that amount already paid. 
    
    - `View`  
          We also used *`studentPaymentView`* method in *`PaymentController`* to show details of a payment information.


   
# Reports Module
From this module we can see detail, export in excel, download in pdf file and print reports of some modules and submodules.

- Admission:
         In admission submodule there are 3 type of students *`Normal Students`*, *`Insolvent & Meritorioue Students`* and *`Foreign Students`*.
         This submodule has relation with *`session`* module and *`course`* submodule. You can get list of students by filtering with session and course.
         
   - `Normal Students`  
             First, just filter by course and session, a list of normal student will be shown with the help of *`admissionReportByType`* method in *`ReportController`*.
             Now you can *`export`* all students in excel file by clicking on 'Export' button with the help of *`exportAdmissionReportByType`* method in *`ReportController`*. 
             And can *`print`* by clicking on 'Print' button with the help of *`printAdmissionReportByType`* method in *`ReportController`*. 
             To print single student detail information just click on 'view' button from table 'action' column, you will move to detail page and now click on 'Print' button. 
             Print window will be open by method *`applicantSingleDetailPrint`* in *`ReportController`*.
                
   - `Insolvent & Meritorioue Quota`  
             Again, at first filter by course and session, a list of 'Insolvent & Meritorious Quota' student will be shown with the help of *`admissionReportByType`* method in *`ReportController`*.
             Now you can *`export`* all students in excel file by clicking on 'Export' button with the help of *`exportAdmissionReportByType`* method in *`ReportController`*. 
             And can *`print`* by clicking on 'Print' button with the help of *`printAdmissionReportByType`* method in *`ReportController`*. 
             To print single student detail information just click on 'view' button from table 'action' column, you will move to detail page and now click on 'Print' button. 
             Print window will be open by method *`applicantSingleDetailPrint`* in *`ReportController`*.
             
   - `Foreign Student`  
             First, just filter by course and session, a list of 'Insolvent & Meritorious Quota' student will be shown with the help of *`admissionReportByType`* method in *`ReportController`*.
             Now you can *`export`* all students in excel file by clicking on 'Export' button with the help of *`exportAdmissionReportByType`* method in *`ReportController`*. 
             And can *`print`* by clicking on 'Print' button with the help of *`printAdmissionReportByType`* method in *`ReportController`*. 
             To print single student detail information just click on 'view' button from table 'action' column, you will move to detail page and now click on 'Print' button. 
             Print window will be open by method *`applicantSingleDetailPrint`* in *`ReportController`*.
   
   
   - Attendance By Term:
        This sub modules has relation with module *`session`* and submodules *`course`*, *`phase`* and *`term`*.
        You can see term attendance report by *`attendanceByTermReport`* method in *`ReportController`*. and also can export data in excel by clicking 'Export' button. 
        Data will be exported with the help of function *`attendanceByTermReportInExcel`* in *`ReportController`*.
     
        
   - Attendance By Phase:
        This sub modules has relation with module *`session`* and submodules *`course`*, and *`phase`*.
        You can see phase attendance report by *`attendanceByPhaseReport`* method in *`ReportController`*. and also can export data in excel by clicking 'Export' button. 
        Data will be exported with the help of function *`attendanceByPhaseReportInExcel`* in *`ReportController`*.
        
        
   - Attendance By Student:
        This sub modules has relation with module *`session`*, *`student`* and submodules *`course`*, *`phase`*, *`Term`* and *`subject group`*.
        You can see student attendance report by *`attendanceByStudentReport`* method in *`ReportController`*. and also can export data in excel by clicking 'Export' button. 
        Data will be exported with the help of function *`attendanceByStudentReportInExcel`* in *`ReportController`*.
        
   - Exam Result:
        This sub modules has relation with module *`session`* and submodules *`course`*, *`phase`*, *`Term`*, *`exam category`*, *`exam`* and *`subject group`*.
        You can see exam result report by *`index`* method in *`ReportExamResultController`*. and also can export data in excel by clicking 'Export' button. 
        Data will be exported with the help of function *`exportResultsByCategory`* in *`ReportExamResultController`*.
      
         
   - Exam Result By Phase:
        This sub modules has relation with module *`session`* and submodules *`course`* and *`phase`*.
        You can see exam result by phase report by *`resultByPhase`* method in *`ReportExamResultController`*. and also can export data in excel by clicking 'Export' button. 
        Data will be exported with the help of function *`exportResultsByPhase`* in *`ReportExamResultController`*.
        
        
   - Exam Results By Student:
         This sub modules has relation with module *`session`*, *`student`* and submodules *`course`*, *`phase`*, *`Term`*, *`exam category`*, *`exam`* and *`subject group`*.
         You can see student exam result report by *`resultByStudent`* method in *`ReportExamResultController`*. and also can export data in excel by clicking 'Export' button. 
         Data will be exported with the help of function *`exportResultsByStudent`* in *`ReportExamResultController`*.
      
         
   -  Student Payment:
         This sub modules has relation with module *`session`*, *`student`* and submodule *`course`*.
         You can see student payment report by *`studentPaymentReport`* method in *`ReportController`*. and also can export data in excel by clicking 'Export' button. 
         Data will be exported with the help of function *`exportStudentPaymentReport`* in *`ReportController`*.
      
         
   - Student List:
      This sub modules has relation with module *`session`* and submodules *`course`*, *`phase`*, and *`student category`*.
      You can see student list report by *`studentListReport`* method in *`ReportController`*. and also can print data by clicking 'Print' button, with the help of function *`studentListPrint`* in *`ReportController`*. 
      Also can see details of student by clicking on 'view' button from list page with the help of *`studentSingleReport`* method in *`ReportController`*. 
      Again also can print single student data by clicking on 'Print' button with the help of *`studentSinglePrint`* method  in *`ReportController`*.
      
      
   - Teacher List:
      This sub modules has relation with submodules *`course`* and *`department`*.
      You can see teacher list report by *`teacherListReport`* method in *`ReportController`*. and also can print data by clicking 'Print' button, with the help of function *`teacherListPrint`* in *`ReportController`*. 
      User also can see details report of student by clicking on 'view' button from list page with the help of *`teacherSingleReport`* method in *`ReportController`*. 
      Again also can print single student data by clicking on *`teacherSinglePrint`* method lies in *`ReportController`*.