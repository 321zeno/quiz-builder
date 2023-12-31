The Quiz Builder app allows registered users to create a Quiz based on the Open Trivia Database

Prerequisites:
 - Docker
 - PHP 8.1

Setup:

- `cp .env.example .env`
- `composer install`
- `./vendor/bin/sail up` - The first run will take some time while the Docker images are download. If any of the container ports are already in use on your host machine, you can set up new ports to be forwarded using the environment variables defined in docker-compose.yml (for example FORWARD_DB_PORT=13306 in .env)
- `./vendor/bin/sail artisan key:generate`
- `./vendor/bin/sail artisan migrate`
- `./vendor/bin/sail artisan db:seed
- `npm install && npm run dev`

A test user is seeded by default:
 - u: demo@trivia.demo
 - p: demo

Running tests:
- `./vendor/bin/sail phpunit --group=quiz`

TODO:
 - An interface that allows quiz participants to complete quizzes
 - An interface that allows quiz creators to see participants scores
 - A more pleasant interface
