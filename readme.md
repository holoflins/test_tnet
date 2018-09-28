## How start project

launch command 
```make init```

add next line in /etc/hosts
``` 127.0.0.1   test_tnet.local ```

copy .env.dist to .env

## How it works 
I created a generic REST application, in ```www/```. Services can be found in ```src/API/```.  
By default, every entity will be callable with the generic actions. In order to create a new working entity, it needs to implement the EntityInterface and have a repository implementing the RepositoryInterface.
You will also need to create a FormType for it if you want to persist it in the database.

Routes are configured in ```config/routes/api.yaml```.
Actions are in ```src/Controller/ApiController```.  
If an entity should not be managed with these REST actions (like category in this exercice), you can disable it in ```config/routes/api.yaml```  
Symfony's Forms are used to hydrate and validate the objects before they get persisted in database.

I used dataFixtures to load products and categories in the database.

I separated tests in three categories small/medium/large (like google approach). In the Small folder, you can find all the unit tests. In the Large folder you can find the functional tests. Functional tests need a database to work.


## TODO 

1.I have to add a symfony security component to configure permissions. After that I will use the security annotations with methods create, update and delete to stop anonymous users.

2.I have to add a logger. After installing monolog, I will use a listener on ```OnKernelException``` to catch every ApiException and format them in a json response.

3.I have to configure the test database correctly. Currently, I use the dev database but it's a bad practice. I need to configure a test database in phpunit.xml.dist and in doctrine config files.

## makefile's command

- make start : install and start containers
- make stop: stop containers
- make shell-php: connect to php containers
- make shell-sql: connect to sql containers
- make install-vendor: install vendors behind dockers
- make test: launch all tests
- make small-test: launch small test (unit test)
- make medium-test: launch medium test (integration test)
- make large-test: launch large test (functional test)
