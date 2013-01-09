#!/bin/sh

# A script to generate cscope database for HFBorrowAC

find -name *.php > cscope.files
cscope -bq

