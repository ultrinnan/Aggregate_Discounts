# Aggregate_Discounts

Task is to connect to one partner API (mocked), gather the discounts and present them to a submitter (employee) so that he can submit discounts.

---

To run the project:

1. Install all required dependencies by running in terminal:

    ```composer install```

2. Create MySQL database and add credentials to .env.local file

3. database preparation
    ```
    php bin/console doctrine:migrations:migrate
    php bin/console doctrine:fixtures:load
    ```

3. run local server to see application in action:
    
    ```php bin/console server:start```

    or visit http://discounts.fedirko.pro to see live demo
    
4.  provide detailed feedback :)
