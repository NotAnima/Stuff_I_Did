# CSC1107OS

There are several cryptographic libraries in C we can use to do encrypt data using SHA512, SHA384, SHA256, SHA1, and MD5.

# 1. OpenSSL
API for hashing, encryption, decryption
Header files can be found in the official OpenSSL website: https://www.openssl.org/source/ or just git clone: https://github.com/openssl/openssl
  - void SHA512(const unsigned char *data, size_t len, unsigned char *md);
  - void SHA384(const unsigned char *data, size_t len, unsigned char *md);
  - void SHA256(const unsigned char *data, size_t len, unsigned char *md);
  - void SHA1(const unsigned char *data, size_t len, unsigned char *md);
  - void MD5(const unsigned char *data, size_t len, unsigned char *md);
  # Sample Code
```
#include <stdio.h>
#include <openssl/sha.h>
#include <openssl/md5.h>

int main() {
    char data[] = "Hello, world!";
    unsigned char hash[SHA256_DIGEST_LENGTH];

    SHA256((unsigned char*)data, strlen(data), hash);

    printf("SHA256 hash: ");
    for (int i = 0; i < SHA256_DIGEST_LENGTH; i++) {
        printf("%02x", hash[i]);
    }
    printf("\n");

    return 0;
}
```
# 2. Libgcrypt
Usable only on linux distributions like the PI. Since Q1 requires us to use systemctl to run a shell script on boot-up. Pretty safe to assume we are doing this with the RaspberryPi.
  - sudo apt-get install libgcrypt20-dev
  - #include <gcrypt.h>

# Will eventually replace this section by our documentation steps
