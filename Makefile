#!/usr/bin/make -f

local-test:
	phpunit tests

push:
	git push origin master

publish-patch: push
	@python2.7 tag.py patch

publish-minor: push
	@python2.7 tag.py minor

publish-major: push
	@python2.7 tag.py major

############################################################

test:
	docker-compose run sdk make local-test	
