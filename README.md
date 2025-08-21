# lemone-blog
## Opdracht Jeffrey Nijkamp

</br>Applicatie gemaakt met PHP 8.3.10. Run de applicatie in Docker.

in de root van de applicatie via de CLI </br>
#### Start de containers
``
docker-compose up -d
`` </br>
#### Vul de database met demodata
``
docker exec -it lemone-blog-php php /var/www/html/init.php
``

De applicatie kan bekeken worden via <a>http://localhost:8080/</a>