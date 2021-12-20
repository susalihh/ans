#!/bin/bash

hostname

IFS=$'\n'
for i in `cat /etc/sudoers.d/domainadmins`; do echo $i; done
