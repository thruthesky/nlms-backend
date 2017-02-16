# Backend

Backend is a Framework for serving Database through REST API.

## Developers

JaeHo Song <thruthesky@gmail.com>

And withcenter team members.


# Overview

## Why?

1. You cannot search fields on firebase database.
2. You can search fields on many other NoSQL DaaS.
	1. But those are not free service. The more you get service, the more you pay.
	2. But NoSQL is not familiar yet and may produce big mistakes.
	3. NoSQL has no **Standard**. You have to learn everything over again on each NoSQL. Meaning if you change NoSQL, your life will be hard.
3. SQL is
	1. Standard
	2. Good and Open Sourced Databases.
	3. Very familiar to developers.
	4. It's almost free. You need to pay only for hosting.



# TODO

* Video tutorial shooting for easy installation.
	* Install with php + its built webserver + sqlite.
	* Install in http://cafe24.com




* forum

    ?mc=forum.config.create
    ?mc=forum.config.update
    ?mc=forum.config.delete
    
    ?mc=forum.data.create&parent=...&title=....&content=....
    
    ?mc=forum.data.update
    ?mc=forum.data.delete
    
    
* file management.

    ?mc=file.upload
    ?mc=file.download
    ?mc=file.delete



    
* @check @re-think Make meta functions available on all model.

    * Use traits.
    
    
    
* @done support sqlite for easy use.

    * Use same SQL schema for mysql and sqlite.
    
    * make it optional on config.php



* Make a filipino Angular community.

* [ Gem ] Video tutorial on easy installation.


    * documentation with video on installing PHP and running with PHP built-in Web server with Backend+sqlite.
    
    * shoot video on installing Backend+SQLite with GoDaddy and Cafe24.

    * Gem will shoot it and upload it on filipino Angular community.
    
    * Mr. Song will make korean dubbing.

    
* file upload and download.

    * DO some think like
        * index.php?mc=data.image&width=120&height=80&quality=70&resize=crop and create a realtime optimized image.
            * md5 filename with mime type. "md5.image+png", "md5.application+x-download", "md5.video"
                * replace '/' to '+'
            * documentation of cache the image with etag on web server configuration.
            * cache image after create with name like "filename-120-80-70-resize.jpg"
                * and check if file exists with same name. if yes, just send it. if not, create a new optimized image.

* User Activity Log.

    * How many times a user had logged in/out.
    * How many times a user read a post.
    * Who did that class reservation?
    * Who can cancel the class? when, what, ...
    * last visit of a user.
    * Search a user who did reservation on last weekend.

* backend-admin project.

    * create a backend-admin with aonic to manage backend and unit test.
    

* @done autoload
* @done namespace

## TODO - Unit Test on PHP

* test on meta.
 

## TODO - Unit Test on Javascript.

* Creat a test class and do it.

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


* download/pull-out the code from https://github.com/thruthesky/backend
* upload to server.
* Edit 'config.php' for database connection.
* mkdir 777 data
* Access http://YOUR-WEBSITE.COM/?mc=system.install




# Configuration

* edit etc/config.php to configure the system.
* Developers can create an optional my-config.php to suppress and overwrite the config.php
    * For instance, you don't want to touch the default config.php but to add your own database information.


# UNIT TEST


## Folder & File sturcture

* test file must end with "_test.php"

* test file should be with the original php script.

* test file must be in a class and follow the namespace.

* __constructor() of test class should not run any test.

* test class must have run() method to run all the test.

* To test all tests.

    * ?mc=test.all

* To test whole tests of a class.

	* ?mc=base.base_test.run

* To test a method
	* ?mc=base.base_test.method_name



# Resources

## Backend Angular API

* It is a ready-to-use Angular API Module for backend. Use it angular and ionic project.
    * https://github.com/thruthesky/backend-angular-api
    
## Backend Admin

* It is a client-end admin site to manage 'backend'.

    * https://github.com/thruthesky/backend-api



# API PROTOCOLS


## Call a method


* ?mc=user.create

    * If you do this, 'model/user/create.php' will be loaded, which means the constructor of the class is the starter of the protocol.
    
    
* ?mc=user.create.func
* ?mc=core.info.version 
    * If you call this, "model/user/create.php" will be loaded and the method 'func' is the starter of the protocol.


* when model name and class name are equal and you want to call a method in that class, you can omit class name.
    ( 번역: 모델 이름과 클래스 이름이 같다면 클래스 이름을 생략 할 수 있다 )
    * for instance, 'user' model has 'user' class and you to call 'data' method of 'user' class, then
    ( 번역 예를 들면 'user' 모델에 'user' 클래스가 있고 'user' 클래스의 'data' 메소드를 호출 하고 싶다면 )
        * "?mc=user.data" will do.
        ( 번역: "?mc=user.user.data" 와 같이 할 필요 없이 줄여서 "?mc=user.data" 와 같이 할 수 있다 )



## User Protocols



### Create a user / User registration


User registration api.

````
?mc=user.create&id=xxxx&password=xxxxx&other_fields=....
````

If success, 'session_id' will be returned.


### Logout

User login api.

````
?mc=user.logout&session_id=xxxxxxx
````

If success, 'session_id' will be deleted on user's record.


### Update user data

User can update his data.

````
?session_id=....&email=...
````

If success, updated 'session_id' will be returned.

#### Admin can update user data

````
?session_id=admin_session_id&idx=user_idx&name=...&other_fields=...
````





### User Login

User login api.

````
?id=....&password=....
````

If success, new 'session_id' will be returned.



### Get User Data

* User can get his data like

````
?mc=user.data&session_id=user_session_id
````


#### Admin can get user data.

Admin can get user's data like

````
?mc=user.data&session_id=admin_session_id&idx=user_idx
````

Admin must pass 'idx' parameter or error will be returned.

    
 
### User Search


* Only admin can search users.

* You can do the combination of page, limit and cond.
* 'cond' holds the search condition.
* You cannot put ';', 'SELECT', 'UPDATE', 'DELETE', 'REPLACE' on 'cond' param.
* 'cond' param must be url_encoded.

* page and limit
	* ?mc=user.search&page=3&limit=10
		* This gets 10 users on 3rd page.

* field search
	* http://localhost/?mc=user.search&cond=id%3d%27admin%27
	* http://localhost/?mc=user.search&cond=id%20LIKE%20%27admin%27
	* http://localhost/?mc=user.search&cond=id%20LIKE%20%27user%-2%%27
		* To search user like 'user-', you need to submit 'user%-'. This is the way SQL should be. Try to avoid searching hypen(-).
	

        
## Forum Protocols


        

## Response

### Success Response


### Error Response

When there is error
* 'code' is not 0.
* if there are many errors, 'code' is the code of last error, 'message' is the message of last error, 'all' has the rest of errors.

````
    {
      "code": -40081,
      "message": "insert-failed",
      "all": [
        {"code":-40040,"message":"model-class-not-found"},
        {"code":-40042,"message":"model-class-empty"}
      ]
    }
````   




# Debug Log

do the following.


    define('DEBUG_LOG_FILE_PATH', './data/debug.log');
    touch data/debug.log
    chmod 777 data/debug.log 
    tail -f data/debug.log




    
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



# CODING GUIDELINE - DEVELOPER MANUAL


## Customs.

* model folder and class php file name MUST BE in lower characters for OS compatibility.

## Model Base Class

* model must have a model class php file with same name of the model.

    * for instance, if a model name is 'abc', then "mode/abc/abc.php" must exists and must have the base code of the model.
    
* model base class SHOULD have "model.class.method" controllers.

    * for instance, if you want to get user data, "?mc=user.user.data" should be queried.
    
