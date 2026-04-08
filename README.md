# evotym_orders

**Start microservice_infra if it's not started yet with by running inside microservice_infra project:**

docker compose up -d --build

**Run inside this project:**

docker compose up -d --build

docker compose exec order-service php bin/console doctrine:migrations:migrate --no-interaction