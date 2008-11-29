#!/bin/bash

svn export /www-root/studs_dev/files /tmp/studs; cd /tmp; tar zcf studs.tar.gz studs; cd -; rm -rf /tmp/studs; mv /tmp/studs.tar.gz /www-root/studs_dev/files/sources/

