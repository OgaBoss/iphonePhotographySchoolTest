

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

### Response 

<img width="517" alt="Screenshot 2023-12-09 at 10 17 23 PM" src="https://github.com/OgaBoss/iphonePhotographySchoolTest/assets/16806901/3a50da88-0aac-419f-a85e-1f8c820d58e5">
