build:
	docker-compose -f deploy/local/docker-compose.yaml up -d --build

# Wake up docker containers
up:
	docker-compose -f deploy/local/docker-compose.yaml up -d

stop:
	docker-compose -f deploy/local/docker-compose.yaml stop

prepare-nginx:
	docker-compose -f deploy/local/docker-compose.yaml up -d --no-deps --build nginx

prepare-front:
	docker-compose -f deploy/local/docker-compose.yaml up -d --no-deps --build nuxt-frontend

prepare-back:
	docker-compose -f deploy/local/docker-compose.yaml up -d --no-deps --build laravel-backend