# TrackingApp
This app is built for the community that wanna be healthy. The leader can monitor all of the member and alert them if they miss training

step by step to use it (for dev):
1. install docker
2. go to src/
3. docker compose up -d
4. (Opsi 1 - Via Apache): Akses langsung ke http://localhost:8080 di browser (Apache sudah dikonfigurasi untuk CI4).
   (Opsi 2 - Via PHP Spark Serve): docker compose exec app php spark serve --host 0.0.0.0 --port 8080, lalu akses ke http://localhost:8080.

if there are errors about writing function or 403 Forbidden, try this:
- docker compose exec app bash
- chown -R www-data:www-data .
- Jika masih error, rebuild container: docker compose down && docker compose build --no-cache && docker compose up -d