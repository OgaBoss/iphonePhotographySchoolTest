

## Back-end Developer Test

### Run the following commands to set up the test

```
composer install

php artisan migrate

php artisan  app:seed-users-details <Lesson Watched Count> <Comments Written Count> 

e.g
php artisan app:seed-users-details 60 45
This will seed 1 user, 60 watched videos, 45 written comments
The DB is cleared before data is seeded, so there is always only one user in the db.
```

### To start the app

```yaml
php artisan serve

The app should start running at http://127.0.0.1:8000

Test the api response at http://127.0.0.1:8000/users/1/achievements
```
