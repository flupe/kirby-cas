# Kirby CAS

A [Kirby] plugin allowing user login using an external [CAS].
It adds a new button under the panel login form to connect through CAS.

[Kirby]: https://getkirby.com
[CAS]: https://en.wikipedia.org/wiki/Central_Authentication_Service

# Installation

```
git submodule add https://github.com/flupe/kirby-cas site/plugins/kirby-cas
git submodule update --init --recursive
```

# Configuration

Under the hood, **kirby-cas** uses [phpCAS].
Therefore, plugin options reflect what [phpCAS] expects.

[phpCAS]: https://github.com/apereo/phpCAS

You can specify the location of the CAS server with the following options:

```php
<?php
  return [
    'flupe.kirby-cas.host'       => 'cas.ens-lyon.fr',
    'flupe.kirby-cas.context'    => '/cas',
  ]
```

Then, you need to declare which CAS username is associated to which Kirby User.
This can be done by extending the default user blueprint and adding a new field for the username.
In `site/blueprints/users/default.yml`, you can put:

```yaml
title: User

fields:
  info:
    type: info
    label: About CAS login
    text: One can enable login through the CAS by specifying their CAS username below.

  cas:
    type: text
    label: CAS username
```

Once this is done, you have to tell **kirby-cas** which field should be used for finding users by CAS username:

```php
<?php

  return [
    'flupe.kirby-cas.user-field' => 'cas',
  ]
```
