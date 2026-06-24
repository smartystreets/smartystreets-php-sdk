#!/usr/bin/make -f

setup:
	composer install

test:
	./vendor/bin/phpunit --exclude-group "integration" tests

test-integration:
	./tests/run_integration_test.sh

package: test
	#@echo -n ""

release: package
	#@echo -n ""

international_autocomplete_api:
	php examples/InternationalAutocompleteExample.php

international_postal_code_api:
	php examples/InternationalPostalCodeExample.php

international_street_api:
	php examples/InternationalExample.php

us_autocomplete_pro_api:
	php examples/USAutocompleteProExample.php

us_autocomplete_api:
	php examples/USAutocompleteExample.php

us_enrichment_api:
	php examples/USEnrichmentExample.php && php examples/USEnrichmentGeoReferenceExample.php && php examples/USEnrichmentSecondaryExample.php && php examples/USEnrichmentGenericExample.php && php examples/USEnrichmentBusinessExample.php && php examples/USEnrichmentBusinessNameSearchExample.php && php examples/USEnrichmentEtagExample.php

us_enrichment_business_api:
	php examples/USEnrichmentBusinessExample.php

us_enrichment_business_name_search_api:
	php examples/USEnrichmentBusinessNameSearchExample.php

us_enrichment_etag:
	php examples/USEnrichmentEtagExample.php

us_extract_api:
	php examples/USExtractExample.php

us_reverse_geo_api:
	php examples/USReverseGeoExample.php

us_street_iana_timezone_api:
	php examples/UsStreetIanaTimeZoneExample.php

us_street_match_strategy_api:
	php examples/USStreetLookupsWithMatchStrategyExamples.php

us_street_api:
	php examples/UsStreetSingleAddressExample.php && php examples/UsStreetMultipleAddressesExample.php && php examples/UsStreetComponentAnalysisExample.php && php examples/UsStreetIanaTimeZoneExample.php && php examples/USStreetLookupsWithMatchStrategyExamples.php

us_zipcode_api:
	php examples/UsZIPCodeSingleLookupExample.php && php examples/UsZIPCodeMultipleLookupsExample.php

examples: international_autocomplete_api international_postal_code_api international_street_api us_autocomplete_pro_api us_autocomplete_api us_enrichment_api us_extract_api us_reverse_geo_api us_street_api us_zipcode_api

.PHONY: setup test package release examples international_autocomplete_api international_postal_code_api international_street_api us_autocomplete_pro_api us_autocomplete_api us_enrichment_api us_enrichment_business_api us_enrichment_etag us_extract_api us_reverse_geo_api us_street_api us_street_iana_timezone_api us_street_match_strategy_api us_zipcode_api
