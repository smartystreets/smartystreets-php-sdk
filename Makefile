#!/usr/bin/make -f

test:
	phpunit tests

push:
	git push origin master

publish-patch: push
	@python2.7 tag.py patch

publish-minor: push
	@python2.7 tag.py minor

publish-major: push
	@python2.7 tag.py major