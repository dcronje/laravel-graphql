#!/usr/bin/env bash
openssl genrsa -des3 -passout pass:foobar -out rootCA.key 2048 
openssl req -x509 -new -nodes -key rootCA.key -passin pass:foobar -subj '/CN=Development SSL/O=STT/C=ZA' -sha256 -days 1024 -out rootCA.pem
