#!/usr/bin/perl


open (FILE,"../admin/logs_studs.txt");

while (<FILE>){

	/.*\t(.*u-strasbg.fr)\t.*/;

	print $1."\n";


}


