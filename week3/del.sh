#!/bin/bash
curl -X DELETE -d "{\"key\":\"${1}\",\"password\":\"test\",\"uid\":\"campbest\"}" \
                -H "Content-Type: application/json" \
                        http://ceclnx01.cec.miamioh.edu/~campbest/cse451-campbest-web-public-2021/kv/kv.php/api/v1/info
