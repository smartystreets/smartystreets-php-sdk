#!/usr/bin/make -f

INCREMENT='patch' # or 'minor' or 'major'

test:
	phpunit .

publish:
	git push origin master
	@python tag.py $(INCREMENT)