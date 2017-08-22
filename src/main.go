package main

import (
	"fmt"
	"net/http"
)

var URLPath []string

type webPage struct {
	code  int
	title string
	body  string
}

func router(w http.ResponseWriter, r *http.Request) {
	fmt.Println("url: ", r.URL.Path)
	switch URLPath[1] {
	case "all":
		allPage()
	default:
		errorPage(404)
	}
	fmt.Fprintf(w, "Comming soon...", URLPath[1])
}

func thread() {

}

func section() {

}

func mainPage() {

}

func allPage() {
	fmt.Println("test")
}

func errorPage(code int) {
	fmt.Println("code: ", code)
}

func main() {
	http.HandleFunc("/", router)
	http.ListenAndServe(":1199", nil)
}
