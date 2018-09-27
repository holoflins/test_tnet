## How start project
clone project on ###
launch command 
```make init```

add next line in /etc/hosts
``` 127.0.0.1   nomDuProject.local ```

copy .env.dist to .env

## How it works
I make generic rest application. src/API are services for generic rest api.
You can call all entities created on project. 

config/routes/api.yaml declare all generics route and in src/Controller/ApiController ther are all methods.

By default all entities are callable with this generic solution. 
If an entity is not writable (like category in this exercice), you can stop it in route's file configuration.

Symfony Form component are used for hydrate and validate data to entity's object before persist it.

I used dataFixtures to load products and categories in database.

I separate tests in three categories small/medium/large (like google approach).
In small you can see all unit tests. In large you can see functional tests. I need to use database to test all actions in functional test

You can use Makefile to launch multiple actions command

## TODO
1.I have to add symfony security component to configure permissions.
After that I use security annotation on methods create/update and delete to stop anonymous users.

2.I have to add logger. After install monolog, I use a listener on OnKernelException to catch all ApiException and format it in json response.

3.I have to configure correctly test database. Actually I used dev database (fastly and quickly) but it's a bad practice. I need to configure test database in phpunit.xml.dist and in doctrine config files.

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