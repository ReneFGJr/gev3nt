path "c:\Program Files\Git\mingw64\bin\"
openssl pkcs12 -in arquivo.p12 -nocerts -out chave.key -nodes
echo "Remove a Chave"
openssl rsa -in chave.key -out key.pem
echo "Extraindo o PEM"
openssl pkcs12 -in arquivo.p12 -clcerts -nokeys -out cert.pem

copy key.pem ..\key_luciana.pem
copy cert.pem ..\cert_luciana.pem


