#!/bin/sh

trap `rm -f tmp.$$; exit 1` 1 2 15

for i in 1 2 3 4 5
do
	head -`expr $i \* 2750` u-adventure-category.data | tail -2750 > tmp.$$
	sort -t"	" -k 1,1n -k 2,2n tmp.$$ > u-adventure-category$i.test
	head -`expr \( $i - 1 \) \* 2750` u-adventure-category.data > tmp.$$
	tail -`expr \( 5 - $i \) \* 2750` u-adventure-category.data >> tmp.$$
	sort -t"	" -k 1,1n -k 2,2n tmp.$$ > u-adventure-category$i.base
done

