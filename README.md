# evotym_orders

docker compose up -d --build

Also need product_service and microservice_infra be started

To start consumer separately

docker compose exec order-service php bin/console messenger:consume product_events -vv 