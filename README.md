0)  Make sure you have PHP on your system. If you dont have it installed already, fetch composer:
    ```curl -sS https://getcomposer.org/installer | php```
    Also, make sure you have docker on your system.

1)  Run:
    ```php composer.phar install```

2)  Launch selenium via:
    ```docker run -d -p 4444:4444 -p 5900:5900 -v /dev/shm:/dev/shm selenium/standalone-firefox:4.0.0-alpha-7-prerelease-20200907```

3)  If you want to see the tests being performed, for debugging, use a VNC viewer to connect to the container at:
    ```vnc://localhost:5900```
    where the password is `secret`

4)  Run:
    ```SELENIUM_URL=localhost:4444 && export SELENIUM_URL```
    then:
    ```vendor/bin/phpunit GitHubTests.php```

