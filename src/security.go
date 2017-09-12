package main

import (
	"regexp"
	"strings"
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
