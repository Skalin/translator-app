Yii 2 Dockerized
================

### Installation

1. git clone
2. cd REPO_DIR/build
3. docker compose build
4. cd ..
5. docker compose build
6. docker compose up -d


After initialization, it is needed to open the web container and run: `php yii migrate up`, which will process all migrations. This will init application with two languages - Czech (cs) and English (en).

If you dont want to run migrations, you can just use the `init.sql`  which is present in `/sql/` directory. This will insert all data according to the the specification given by DEVIX. This means that the ro and en languages are initialized. Also there are two translations with all translations filled.