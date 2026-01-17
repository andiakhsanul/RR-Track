# Makefile for RR-Track Laravel Docker Development

.PHONY: help build up down restart logs shell mysql redis composer artisan npm fresh migrate seed test

# Default target
help:
	@echo "RR-Track Docker Commands:"
	@echo ""
	@echo "  make build      - Build Docker images"
	@echo "  make up         - Start all containers"
	@echo "  make down       - Stop all containers"
	@echo "  make restart    - Restart all containers"
	@echo "  make logs       - View container logs"
	@echo "  make shell      - Access app container shell"
	@echo "  make mysql      - Access MySQL CLI"
	@echo "  make redis      - Access Redis CLI"
	@echo "  make composer   - Run composer command (use: make composer c='install')"
	@echo "  make artisan    - Run artisan command (use: make artisan c='migrate')"
	@echo "  make npm        - Run npm command (use: make npm c='install')"
	@echo "  make fresh      - Fresh install (migrate:fresh --seed)"
	@echo "  make migrate    - Run migrations"
	@echo "  make seed       - Run seeders"
	@echo "  make test       - Run tests"
	@echo "  make optimize   - Optimize Laravel"
	@echo "  make clear      - Clear all caches"

# Build Docker images
build:
	docker-compose build

# Start containers
up:
	docker-compose up -d

# Stop containers
down:
	docker-compose down

# Restart containers
restart:
	docker-compose restart

# View logs
logs:
	docker-compose logs -f

# Access app shell
shell:
	docker-compose exec app bash

# Access MySQL CLI
mysql:
	docker-compose exec db mysql -u rrtrack -psecret rrtrack

# Access Redis CLI
redis:
	docker-compose exec redis redis-cli

# Run composer commands
composer:
	docker-compose exec app composer $(c)

# Run artisan commands
artisan:
	docker-compose exec app php artisan $(c)

# Run npm commands
npm:
	docker-compose exec app npm $(c)

# Fresh database
fresh:
	docker-compose exec app php artisan migrate:fresh --seed

# Run migrations
migrate:
	docker-compose exec app php artisan migrate

# Run seeders
seed:
	docker-compose exec app php artisan db:seed

# Run tests
test:
	docker-compose exec app php artisan test

# Optimize Laravel
optimize:
	docker-compose exec app php artisan optimize

# Clear all caches
clear:
	docker-compose exec app php artisan cache:clear
	docker-compose exec app php artisan config:clear
	docker-compose exec app php artisan route:clear
	docker-compose exec app php artisan view:clear

# Install Laravel (first time setup)
install-laravel:
	docker-compose run --rm app composer create-project laravel/laravel temp
	docker-compose run --rm app sh -c "mv temp/* temp/.* . 2>/dev/null || true && rmdir temp"
	cp .env.example .env
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan storage:link
