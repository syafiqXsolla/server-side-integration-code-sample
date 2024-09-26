1. First of all, please copy the `.env.example` file to `.env` and fill in the necessary values.
2. Install ngrok via Homerbrew with following command:
```bash
brew install ngrok/ngrok/ngrok
```
3. Run the following command to add your authtoken to the default ngrok.yml configuration file.
```bash
ngrok config add-authtoken {YOUR_NGROK_AUTH_TOKEN}
```
4. Run composer install
```bash
docker exec -it xsolla_example bash -c 'cd /app/xsolla-example ; composer install'
```
5. Run the following command to start the project using docker:
```bash
docker-compose --env-file ./.env -f docker/docker-compose.yml down
# docker kill $(docker ps -q)
docker-compose --env-file ./.env -f docker/docker-compose.yml up --build
```
6. Run ngrok
```bash
docker exec -it xsolla_example bash -c 'ngrok http 8080'
```
7. Open your site on this link: http://localhost:8080
8. Generate a new order by clicking on the "Get token" button.
9. Open the payment UI by clicking on generated payment url.
10. Fill in the payment form and click on the "Pay" button.
11. Send payment webhook to ngrok localhost.
12. You will receive the response from the payment webhook handler stating that payment is success.
