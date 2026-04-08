# evotym_orders

docker compose up -d --build

docker compose exec order-service php bin/console doctrine:migrations:migrate --no-interaction

Also need product_service and microservice_infra be started