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
