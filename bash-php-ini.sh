#!/usr/bin/env bash
memory_limit=2056M
upload_max_filesize=150M
post_max_size=150M
max_execution_time=60
max_input_time=60

for key in upload_max_filesize post_max_size max_execution_time max_input_time
do
 sed -i "s/^\($key\).*/\1 $(eval echo \${$key})/" ~/Desktop/php.ini
done