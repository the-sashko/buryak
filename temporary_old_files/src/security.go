package main

import (
	"math/rand"
	"regexp"
	"strconv"
	"strings"
	"time"
	"unsafe"
)

// #cgo LDFLAGS: -lcrypt
// #define _GNU_SOURCE
// #include <crypt.h>
// #include <stdlib.h>
import "C"

func crypt(key, salt string) string {
	data := C.struct_crypt_data{}
	ckey := C.CString(key)
	csalt := C.CString(salt)
	out := C.GoString(C.crypt_r(ckey, csalt, &data))
	C.free(unsafe.Pointer(ckey))
	C.free(unsafe.Pointer(csalt))
	return out
}

func makeTripCode(input string) string {
	salt := input + "H."
	salt = salt[1:3]
	reg, _ := regexp.Compile("[^\\.-z]")
	salt = reg.ReplaceAllString(salt, "-")
	replacer := strings.NewReplacer(
		":", "A",
		";", "B",
		"<", "C",
		"=", "D",
		">", "E",
		"?", "F",
		"@", "G",
		"[", "a",
		"\\", "b",
		"]", "c",
		"^", "d",
		"_", "e",
		"`", "f",
	)
	salt = replacer.Replace(salt)
	code := crypt(input, salt)
	return "!" + string(code[len(code)-10:])
}

func makeFormToken() string {
	return makeHash("form")
}

func makeSessionToken() string {
	return makeHash("")
}

func makeAuthToken() string {
	return makeHash("")
}

func makeHash(input string) string {
	/*if input == nil {
			input = ""
		}*
		hash := sha1.New()
		hash.Write([]byte(input))
		return base64.URLEncoding.EncodeToString(hash.Sum(nil))
	}

	func makeToken(input string) string {
		/*if input == nil {
			input = ""
		}*/
	salt := "wUenr5#1"
	timestamp := strconv.FormatInt(time.Now().UnixNano(), 10)
	hashString := strconv.Itoa(rand.Int()) + salt + input + timestamp + strconv.Itoa(rand.Int())
	saltString := strconv.Itoa(rand.Int()) + salt + timestamp + strconv.Itoa(rand.Int())
	hashString = makeHash(hashString)
	saltString = makeHash(saltString)
	hash := crypt(hashString, saltString)
	return string(hash)
}
