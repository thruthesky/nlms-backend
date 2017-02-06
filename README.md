# nlms-backend
Backend server for New LMS


# Installation

* Pull out the code
* Edit 'config.php' for database connection.
* Import 'etc/sql/lateset-schema.sql' to database.
* mkdir 777 data
* Access thru website.



# API PROTOCOLS


## Call a method


### Create a user


* ?mc=user.create

    * If you do this, 'model/user/create.php' will be loaded, which means the constructor of the class is the starter of the protocol.
    
    
 * ?mcm=user.create.func
    * If you call this, "model/user/create.php" will be loaded and the method 'func' is the starter of the protocol.


# Database

## User

* many users can have same email address. so, a user can create many id for his family but use only one email for easy management.

* user type
    * 'S' for student
    * 'M' for manager
    * 'T' for teacher
    