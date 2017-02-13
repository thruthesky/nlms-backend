# nlms-backend
Backend server for New LMS

# TODO

@문서화 - php backend server 를 직접 만든 이유
    * rdbms 를 사용 할 수 있도록. NoSQL 도 괜찮지만, 유료이며 제약 사항들이 있음. 특히 firebase 는 검색이 안됨
    * 매우 익숙한 구조. 물론 SQL 을 모르는 사람에게는 익숙하지 않겠지만
    * 무료 또는 웹 호스팅 비용만 지불하면 되는 거의 무료로 무제한적인 사용. 유료 서비스의 경우 사용자가 많을 수록 비용이 많이 올라 감

@문서화 - 동영상 강좌
    * 윈도우즈에서 php 를 다운로드해서 직접 운용
    * cafe24.com 에서 운용
    \

* Meta module. set/get/sets/gets

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
 

## TODO - Unit Test on Karma

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

* It is a good idea to run a unit test after you install.

    access the end point below.

    * ?mc=test.all


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


## User Protocols

### Basics

* "?mc=user.user" MUST response with '{"code":-40041,"message":"no-success-error-response","all":[]}'
* "/?mc=user.user.data" MUST response with {"code":-40104,"message":"session-id-is-empty","all":[]}




### Create a user / User registration


* ?mc=user.create&id=xxxx&password=xxxxx

    * 'session_id' will be returned.

### Logout

* ?mc=user.logout&session_id=xxxxxxx
    * 'session_id' will be deleted on user's record.
    
### Update user data

* ?session_id=....&email=...
    * New 'session_id' will be returned.


### User Login

* ?id=....&password=....
    * 'session_id' will be returned.



# Get User Data

* ?mc=user.data&session_id=.........


    
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
    
