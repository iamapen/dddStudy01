#!/bin/bash
BASE_DIR=$(cd $(dirname $0);pwd)
ROOT_DIR=$(cd $BASE_DIR/..;pwd)

[ -z "$PHP_BIN" ] && PHP_BIN=/usr/bin/php
#PHPUNIT_BIN="${ROOT_DIR}/vendor/phpunit/phpunit/phpunit"
PHPUNIT_SH="${ROOT_DIR}/vendor/bin/phpunit"
REPORT_DIR="${ROOT_DIR}/_build/report/coverage"


pushd "$ROOT_DIR" > /dev/null
#CMD="$PHP_BIN $PHP_OPT $PHPUNIT_BIN --coverage-html='${REPORT_DIR}'"
CMD="$PHPUNIT_SH --coverage-html='${REPORT_DIR}'"
echo $CMD
eval $CMD
popd > /dev/null

