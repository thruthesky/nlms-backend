# nlms-backend
Backend server for New LMS

# TODO

* support sqlite for easy use.

    * Use same SQL schema for mysql and sqlite.
    
    * make it optional on config.php
    
    * 

* make an optional my-config.php to suppress and overwrite the config.php

    * 
    

* Make a filipino Angular community.

* [ Gem ] Video tutorial on easy installation.


    * documentation with video on installing PHP and running with PHP built-in Web server with Backend+sqlite.
    
    * shoot video on installing Backend+SQLite with GoDaddy and Cafe24.

    * Gem will shoot it and upload it on filipino Angular community.
    
    * Mr. Song will make korean dubbing.

    


* User Activity Log.

    * How many times a user had logged in/out.
    * How many times a user read a post.
    * Who did that class reservation?
    * Who can cancel the class? when, what, ...
    * last visit of a user.
    * Search a user who did reservation on last weekend.
    

* @done autoload
* @done namespace


## TODO - Unit Test

* Karma TEST. Test on below.

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
    
# Debug Log

do the following.


    define('DEBUG_LOG_FILE_PATH', './debug.log');
    $ touch debug.log
    $ chmod 777 debug.log 
    $ tail -f debug.log




    
# Database

## User

* many users can have same email address. so, a user can create many id for his family but use only one email for easy management.

* user type
    * 'S' for student
    * 'M' for manager
    * 'T' for teacher

    
## Meta

For metadata of all kinds.

model is the model of the database table name.
model_idx is the idx of the model.
code is the distinguisher of the record.

Examples of usage.

for user meta data.

user.user_idx.code

user.123.first_name


for post meta data.

post.post_idx.code

post.456.writer_address

for comment meta data.

comment.111.writer_address




### base::xxxxMeta* funtions

The model and model_idx are automatically set.


So, you must set the user in 'Base::$record' by 'load()' or 'reset()'

For instance,

If you save a meta like

    $this->saveMeta( 'a', 'b')

depending on what is set to Base::$record,

the model and model_idx are set automatically.

If the code is on the user table, then,

'user' as model and its idx as model_idx will be automatically set.


@attention since, the index is not unique, same 'model.model.idx.code' index can exist.


# Request

* http://localhost/www/nlms-backend/?mc=user.create&id=user3&email=email2@gmail.com


* Registration with meta data.
    * ?id=test-1486715337&password=test-1486715337&name=test-1486715337&nickname=undefined&email=test-1486715337%40gmail.com&mobile=undefined&landline=undefined&gender=undefined&birthday=undefined&meta%5Btype%5D=T&meta%5Bclassid%5D=my-skype-id&mc=user.create&module=ajax&submit=1


* How to set user's meta data.

    * ?mc=user.meta.set&session_id=109-821aca27b85169bfd3d33e4d02cc97d5&code=abc&value=1234

* How to get a meta data of user

    * ?mc=user.meta.get&session_id=109-821aca27b85169bfd3d33e4d02cc97d5&code=abc


* How to get user's all meta data.

    * ?mc=user.meta.gets&session_id=109-821aca27b85169bfd3d33e4d02cc97d5
    