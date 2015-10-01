# Lab to test first and third party cookie tracking

## Requirements

1. Docker
2. No local processes or running containers listening on ports 80/tcp, 53/tcp and 53/udp


## Get started

This lab is composed by 2 docker containers:

* **poc-bind**: container in charge of DNS
* **poc-base**: it's an nginx-fpm container which serves multiple websites, including:
  * 1 adserver/tracking entity
  * 2 publisher websites, which include an adserver tag that renders an Ad
  * 2 advertiser websites, which include an adserver tag, which loads a JS lob to track user conversions

To get the environment up, just execute this command:

```
make all
```

After that, open http://publisherb.local/ to begin with lab interactions.
