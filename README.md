**Setup Guideline**

- run `componser install`
- run `php artisan migrate`
- run `php artisan db:seed`


**Test API**
- url `{url}/api/login`
- method `POST`
- AD User
```
{
    "username": "einstein",
    "password": "password"
}
```
- Normal User
```
{
    "username": "admin",
    "password": "password"
}
```

**Reference**
- Testing AD Server `https://www.forumsys.com/2022/05/10/online-ldap-test-server/`
- PHP Doc `https://www.php.net/manual/en/ref.ldap.php` 
