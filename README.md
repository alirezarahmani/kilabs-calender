Hello

Introduction:
-

I did this test base on Symfony 4 framework(my favourite) and doctrine ORM(for writing, I do not implement read part, If I would, I prefer MemcacheD), It set free times of employer and candidate in 24 hours format.

How To Start:
-
There would not be easier than just running a single command: `./build.sh` in root of project. That's all, there you are.

Important Note:
-
 - I use very simple [Layered Architecture](https://www.culttt.com/2014/11/10/creating-using-command-bus/) in order to [separation of concerns](https://stackoverflow.com/questions/98734/what-is-separation-of-concerns).
 - You might wonder why instead of service I use [Domain Model](https://martinfowler.com/eaaCatalog/domainModel.html)? In fact, I use [domain model pattern](https://stackoverflow.com/questions/41335249/domain-model-pattern-example). 
 - I also create a [Factory](https://www.culttt.com/2014/12/24/factories-domain-driven-design/).

API:
-

## Post [0.0.0.0:81/timesheets]
+ Parameters
    + hour: `12:00:00` (string).
    + date: `2018-08-09` (string).
    + id: `1` (integer).
    + userType: `interviewer` (string).
    + toDate: `2018-10-09` (string) - optional.
    + toHour: `18:00:00 ` (string) - optional.

+ Success (application/json)

    ```json
    {
        "Data": [ ],
        "Status": true,
        "Message": ""
    }
    ```

+ Error (application/json)

    ```json
    {
        "Data": [ ],
        "Status": false,
        "Message": {
          "the requested time slot is already exist"
        }
    }
    ```
    
Test:
-
just run following command: ` docker-compose exec worker php vendor/phpunit/phpunit/phpunit`