WubookAPIBundle
=============
**Notice:** Bundle is stable but not every method mentioned in wubook API docs is implemented. (feel free to contribute)

WubookAPIBundle performs request to wubook.net API, it's Symfony2 bundle.
This bundle completly takes the responsibility of handling token. It saves it under you cache directory and always use it.
Even if you don't have token managed it will acquire it for you (of course if your config is properly filled)

Implemented methods
------------

    acquire_token, release_token, is_token_valid, provider_info, fetch_rooms,
    room_images, new_reservation, fetch_bookings, fetch_booking, fetch_rooms_values,
    new_reservation, cancel_reservation, update_avail
More coming soon

Installation
------------

    $ composer require kamwoz/wubookapi-bundle "dev-master"
    
In AppKernel.php
    
```php
new Kamwoz\WubookAPIBundle\WubookAPIBundle(),
```
        
Configure the bundle (all fields are mandatory):
```yaml
# app/config/config.yml
wubook_api:
    client_username: %wubook_api.client_username%
    client_password: %wubook_api.client_password%
    provider_key: ~ #ask support for it
    property_id: ~ #get it from your account
```

```yaml
# app/config/parameters.yml
parameters:
    wubook_api.client_username: yourUsername
    wubook_api.client_password: yourPassword
```
Example usage (docs coming soon)
------------
```php
//some controller
//fetch bookings from last week
$dateFrom = new \DateTime("-1 week");
$dateTo = new \DateTime();
$bookingArrays = $this->get('wubook_api.booking_handler')->fetchBookings($dateFrom, $dateTo);
```

Current services which can be used
------------
```yaml
wubook_api.booking_handler
wubook_api.token_handler
wubook_api.room_handler
wubook_api.availability_handler
```
