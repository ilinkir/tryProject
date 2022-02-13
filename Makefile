build:
	docker-compose -f deploy/local/docker-compose.yaml up -d --build

# Wake up docker containers
up:
	docker-compose -f deploy/local/docker-compose.yaml up -d

prepare-nginx:
	docker-compose -f deploy/local/docker-compose.yaml up -d --no-deps --build nginx

prepare-front:
	docker-compose -f deploy/local/docker-compose.yaml up -d --no-deps --build nuxt-frontend