# Xsolla Server-Side Integration Example

This repository provides an example of how to integrate Xsolla PayStation and handle payment processing with server-side validation using webhooks.

## Prerequisites

Before running this project, ensure you have the following installed:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Homebrew](https://brew.sh/) (for macOS users)
- [Composer](https://getcomposer.org/) (for PHP package management)
- [Ngrok](https://ngrok.com/) (for exposing your local environment to the web)

## Setup Instructions

### 1. Copy `.env.example` to `.env`
First, create a `.env` file from the provided `.env.example` template:

```bash
cp .env.example .env
```
Next, fill in the necessary values in the .env file

### 2. Install Ngrok
If Ngrok is not installed, install it using Homebrew (macOS only):

```bash
brew install ngrok/ngrok/ngrok
```

### 3. Add Your Ngrok Auth Token
Add your Ngrok authentication token to your default configuration file:

```bash
ngrok config add-authtoken {YOUR_NGROK_AUTH_TOKEN}
```
This will allow you to use Ngrok to expose your local environment publicly.

### 4. Install PHP Dependencies with Composer
Next, install the required PHP packages inside the Docker container:

```bash
docker exec -it xsolla_example bash -c 'cd /app/xsolla-example ; composer install'
```

### 5. Start the Docker Containers
Build and start the project using Docker Compose:

```bash
docker-compose --env-file ./.env -f docker/docker-compose.yml down
docker-compose --env-file ./.env -f docker/docker-compose.yml up --build
```
The application will now be running on http://localhost:8080.

### 6. Run Ngrok
Start Ngrok to expose your local environment for webhook handling:

```bash
docker exec -it xsolla_example bash -c 'ngrok http 8080'
```
Ngrok will provide a publicly accessible URL. Copy the forwarding URL (e.g., https://<random>.ngrok.io) to use with Xsolla webhooks.

### 7. Access Your Site
Open your browser and navigate to: http://localhost:8080

### 8. Generate a New Order
To generate a new order, click on the Get token button. This will generate a token for your payment process.

### 9. Open the Payment UI
Click on the generated payment URL to open the Xsolla PayStation UI.

### 10. Complete Payment
Fill in the payment details in the UI and click the Pay button.
- Test card for payment details (https://developers.xsolla.com/solutions/payments/testing/test-cards/)

### 11. Send Webhook to Ngrok Localhost
Once the payment is completed, send a webhook to your Ngrok URL to notify the payment result.

### 12. Verify Payment
You should receive a response from the payment webhook handler confirming that the payment was successful.







