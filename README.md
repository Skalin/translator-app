Yii 2 Dockerized
================

### Installation

1. git clone
2. cd REPO_DIR/build
3. docker compose build
4. cd ..
5. docker compose build
6. docker compose up -d


To run working examples, it is recommended to copy docker-compose-prod.yml into docker-compose.yml and .env-prod to .env. Therefore no configuration should be then needed.

After initialization, it is needed to open the web container and run: `php yii migrate up`, which will process all migrations. This will init application with two languages - Czech (cs) and English (en).

If you dont want to run migrations, you can just use the `init.sql`  which is present in `/sql/` directory. This will insert all data according to the the specification given by DEVIX. This means that the ro and en languages are initialized. Also there are two translations with all translations filled.


### Usage
The application frontend runs by default on port 3000. It can be changed according to .env file.
The application backend runs by default on port 8080.


# ENV variables
REACT_APP_API_URL - API url on which the backend runs. This should be set to http://localhost:8080/api in current development.
DB_DSN - database dns that the website uses to connect, this should be set to: mysql:host=db;dbname=web
DB_USER= database username that the website uses to connect, this should be set to: web
DB_PASSWORD - database password that the website uses to connect, this should be set to: web

