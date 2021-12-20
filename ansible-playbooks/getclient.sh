#!/bin/bash

carray=()
cip=()
dname=`dnsdomainname`

for word in `sudo samba-tool group listmembers "Domain Computers"`
do
   carray+=(${word::-1}.$dname)
done

for i in ${carray[@]}; do
   cip+=(`host $i`)
done

for (( i = 3 ; i < ${#cip[@]} ; i+=4 ))
do
    echo "${cip[$i]}"
done

