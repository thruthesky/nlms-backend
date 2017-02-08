# nlms-backend
Backend server for New LMS

# TODO

* Adding TEST. Test on below.
    * base::create
    * base::update
    * base::load
    * base::delete
    * user crud.
    * session id.
    * 
    
# Installation

* Pull out the code
* Edit 'config.php' for database connection.
* Import 'etc/sql/lateset-schema.sql' to database.
* mkdir 777 data
* Access thru website.



# API PROTOCOLS


## Call a method


* ?mc=user.create

    * If you do this, 'model/user/create.php' will be loaded, which means the constructor of the class is the starter of the protocol.
    
    
 * ?mcm=user.create.func
    * If you call this, "model/user/create.php" will be loaded and the method 'func' is the starter of the protocol.



### Create a user / User registration


* http://localhost/www/nlms-backend/?mc=user.create&id=user3&email=email2@gmail.com

    * 'session_id' will be returned.


### Update user data

* ?session_id=....&email=...
    * New 'session_id' will be returned.
    
    
# Database

## User

* many users can have same email address. so, a user can create many id for his family but use only one email for easy management.

* user type
    * 'S' for student
    * 'M' for manager
    * 'T' for teacher
    
    
# Unit Test

* http://localhost/www/nlms-backend/?mc=user.create&id=user3&email=email2@gmail.com
