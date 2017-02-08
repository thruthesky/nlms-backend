# nlms-backend
Backend server for New LMS

# TODO

* autoload
* namespace


* Adding TEST. Test on below.
    * test on protocol
        * ?mc=core.info
        * ?mc=core.info.version
    * base::create
    * base::update
    * base::load
    * base::delete
    * user crud.
    * get session id.
    * user::load
    * get user by session id.
    * user::login
    * user::logout



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
    
    
* ?mc=user.create.func
* ?mc=core.info.version 
    * If you call this, "model/user/create.php" will be loaded and the method 'func' is the starter of the protocol.



### Create a user / User registration


* ?mc=user.create&id=xxxx&password=xxxxx

    * 'session_id' will be returned.

###
* ?mc=user.logout&session_id=xxxxxxx
    * 'session_id' will be deleted on user's record.
    
### Update user data

* ?session_id=....&email=...
    * New 'session_id' will be returned.


### User Login

* ?id=....&password=....
    * 'session_id' will be returned.
    
    
    
# Database

## User

* many users can have same email address. so, a user can create many id for his family but use only one email for easy management.

* user type
    * 'S' for student
    * 'M' for manager
    * 'T' for teacher
    
    
# Unit Test

* http://localhost/www/nlms-backend/?mc=user.create&id=user3&email=email2@gmail.com
