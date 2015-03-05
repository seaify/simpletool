#!/bin/sh
curl -O https://pypi.python.org/packages/source/p/pip/pip-1.3.tar.gz
tar xvfz pip-1.3.tar.gz
cd pip-1.3
sudo python setup.py install
