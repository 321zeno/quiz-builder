Prerequisites:
 - Docker

Setup:

- `./vendor/bin/sail up` - The first run will take some time while the Docker images are download. If any of the container ports are already in use on your host machine, you can set up new ports to be forwarded using the environment variables defined in docker-compose.yml (for example FORWARD_DB_PORT=13306 in .env)
