#!/bin/sh

trap `rm -f tmp.$$; exit 1` 1 2 15

for i in 1 2 3 4 5
do
	head -`expr $i \* 5117` u-programmer-occupation.data | tail -5117 > tmp.$$
	sort -t"	" -k 1,1n -k 2,2n tmp.$$ > u-programmer-occupation$i.test
	head -`expr \( $i - 1 \) \* 5117` u-programmer-occupation.data > tmp.$$
	tail -`expr \( 5 - $i \) \* 5117` u-programmer-occupation.data >> tmp.$$
	sort -t"	" -k 1,1n -k 2,2n tmp.$$ > u-programmer-occupation$i.base
done

