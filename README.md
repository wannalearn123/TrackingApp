# TrackingApp
This app is built for the community that wanna be healthy. The leader can monitor all of the member and alert them if they miss training

step by step to use it (for dev):
1. install docker
2. go to src/
3. docker compose up -d
4. docker compose exec app php spark serve

if there are errors about writing function, try this:
- docker compose exec app bash
- chown -R www-data:www-data .