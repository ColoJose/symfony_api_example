
# Symfony Api Example

## Technologies

- Symfony 5 with Doctrine as ORM and phpunit for testing
- NGINX as webserver
- Mysql as the database service

## Requirements

We need `docker` and `docker-compose` to set up the project

## Set up

Open a terminal and type (or copy) the following command on the project directory:

```shell
docker-compose up -d
docker exec symfony_app sh -c 'composer install --no-interaction'
docker exec symfony_app sh -c 'php bin/console doctrine:migrations:migrate'
docker exec main_db sh -c 'cat /home/*.sql | mysql -u symfony_user -psymfony_pass -D symfony_db' 
docker exec debtors_register sh -c 'mysql -u debtors_user -pdebtors_pass -D debtors_register < /home/setup.sql'
```

## Try out endpoints

You can use `curl` from command line as HTTP client or any other you prefer

- List all properties

`curl http://localhost:8080/property`

- Create a house

```shell
echo '{"street":"W Towers", "number": 2100, "zipCode":1331,"sqm":21.1,"location":"Longhcmps","floors":2,"hasGarden":false}' > create_house.json

curl -X POST --data "@/your/path/create_house.json" http://localhost:8080/property?type=house
```

- Filter properties by location

`curl http://localhost:8080/property?location=Camden`

To find the remainings endpoints, execute `docker exec symfony_app sh -c 'php bin/console debug:router'`

## Run tests

`docker exec symfony_app sh -c 'bin/phpunit'`

### TODO

- integrate FieldExistsValidator in the lifecycle of the request

