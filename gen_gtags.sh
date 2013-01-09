#!/bin/sh

# A script to generate GTAGS database for HFBorrowAC

find -name *.php > gtags.files
gtags

