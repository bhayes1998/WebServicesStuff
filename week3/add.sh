#!/bin/bash
curl -X PUT -d "{\"key\":\"${1}\",\"value\":\"${2}\",\"password\":\"test\",\"uid\":\"campbest\"}" \
                -H "Content-Type: application/json" \
                        http://ceclnx01.cec.miamioh.edu/~campbest/cse451-campbest-web-public-2021/kv/kv.php/api/v1/info
