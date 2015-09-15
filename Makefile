IMAGE_DNS=poc-dns
IMAGE_WEBSERVER=poc-base
NAME_DNS=poc-bind
NAME_WEBSERVER=poc-all

all: build run

build:
	docker build --file Dockerfile.dns --tag $(IMAGE_DNS) .
	docker build --file Dockerfile.base --tag $(IMAGE_WEBSERVER) .

run:
	docker run -ti -d -p 53:53 -p 53:53/udp --name $(NAME_DNS) $(IMAGE_DNS) 
	docker run -ti -d -p 80:80 -v $(shell pwd):/srv/shared --name $(NAME_WEBSERVER) $(IMAGE_WEBSERVER)

clean:
	docker rm -vf $(NAME_DNS) && docker rmi $(IMAGE_DNS)
	docker rm -vf $(NAME_WEBSERVER) && docker rmi $(IMAGE_WEBSERVER) 
