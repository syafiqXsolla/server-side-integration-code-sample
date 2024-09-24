
Run docker
```bash
docker-compose --env-file ./.env -f docker/docker-compose.yml down
# docker kill $(docker ps -q)
docker-compose --env-file ./.env -f docker/docker-compose.yml up --build
```

Run ngrok (api key should be in .env file)
```bash
docker exec -it xsolla_example bash -c 'ngrok http 8080'
```

Composer install
```bash
docker exec -it xsolla_example bash -c 'cd /app/xsolla-example ; composer install'
```

Enter docker container
```bash
docker exec -it xsolla_example bash
```