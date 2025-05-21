# Variables para Docker
export UID := $(shell id -u)
export GID := $(shell id -g)

up:
	@echo "🔹 Levantando backend..."
	cd backend && UID=$(UID) GID=$(GID) docker compose up -d --build
	@echo "🔹 Levantando frontend..."
	cd frontend && UID=$(UID) GID=$(GID) docker compose up -d --build

down:
	@echo "🔻 Parando backend..."
	cd backend && UID=$(UID) GID=$(GID) docker compose down
	@echo "🔻 Parando frontend..."
	cd frontend && UID=$(UID) GID=$(GID) docker compose down

logs:
	@echo "🧾 Logs backend..."
	cd backend && docker compose logs -f
	@echo "🧾 Logs frontend..."
	cd frontend && docker compose logs -f

build:
	@echo "🛠 Construyendo backend..."
	cd backend && docker compose build
	@echo "🛠 Construyendo frontend..."
	cd frontend && docker compose build

clean-cache:
	@echo "🧹 Limpiando cachés de PHP..."
	rm -rf backend/.phpcs-cache backend/phpunit.result.cache backend/tests/phpunit.result.cache
	docker exec -it symfony_app rm -rf /var/www/html/.phpcs-cache /var/www/html/tests/phpunit.result.cache

import-cards:
	@echo "🔹 Importando tarjetas..."
	docker exec -it symfony_app bin/console app:import-cards


console-backend:
	@echo "🔧 Entrando al contenedor backend (symfony_app)..."
	docker exec -it symfony_app bash

console-frontend:
	@echo "🔧 Entrando al contenedor frontend (vue_app)..."
	docker exec -it vue_app sh

fix-permissions:
	@echo "🔧 Dando permisos de escritura para www-data..."
	sudo chmod -R ug+rwX .
	sudo chgrp -R 33 .