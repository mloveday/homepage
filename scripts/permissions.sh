#!/bin/bash
mkdir -p /tmp/symfony
HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX /tmp/symfony
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX /tmp/symfony