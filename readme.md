## How start project
clone project on ###
launch command 
```make start  && make vendor-install```

add next line in /etc/hosts
``` 127.0.0.1   nomDuProject.local ```

copy .env.dist to .env


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