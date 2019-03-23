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

4. run local server to see application in action:
    
    ```php bin/console server:start```
    
5. API was created as separate module and can be accessed via link *localhost/api*

6. Initial data - 9 discounts. Database can be renewed by clicking the button in menu. When requesting data from API first time, additional cookie will be stored for 5 minutes. If this cookie present - second call to API will be from second file. 

7. Please provide feedback :)

