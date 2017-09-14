<?php

// Core

Config::write('site.url', 'example.com');
Config::write('admin.email', 'admin@example.com');
Config::write('admin.userIdArray', array()); // array of admin userID integers
Config::write('system.email', 'Admin <admin@example.com>');
Config::write('system.url', 'example.com');

// Data

Config::write('db.host', 'XXXXXXXXXX');
Config::write('db.basename', 'XXXXXXXXXX');
Config::write('db.user', 'XXXXXXXXXX');
Config::write('db.password', 'XXXXXXXXXX');

// Plugins

Config::write('analytics.trackingID', 'XXXXXXXXXX');
Config::write('adsense.data-ad-client', 'XXXXXXXXXX');
Config::write('adsense.data-ad-slot', 'XXXXXXXXXX');
Config::write('googlemaps.embed-api-key', 'XXXXXXXXXX');
Config::write('pingdom.rumID', 'XXXXXXXXXX');
Config::write('alexa.atrk_acct', 'XXXXXXXXXX');
Config::write('ms.validate', 'XXXXXXXXXX');
Config::write('pinterest.domain_verify', 'XXXXXXXXXX');
Config::write('aws.key', 'XXXXXXXXXX');
Config::write('aws.secret', 'XXXXXXXXXX');

?>