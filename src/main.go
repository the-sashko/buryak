package main

import (
	"fmt"
	"html/template"
	"net/http"
	"strings"
)

var URLPath []string

type webPage struct {
	code  int
	title string
	body  string
}

func router(w http.ResponseWriter, r *http.Request) {
	fmt.Println("url: ", r.URL.Path)
	URLPath := strings.Split(r.URL.Path, "/")
	switch URLPath[1] {
	case "all":
		allPage()
	default:
		errorPage(404)
	}
	t, _ := template.New("foo").Parse(`{{define "T"}}Hello, {{.}}!{{end}}`)
	_ = t.ExecuteTemplate(w, "T", "<script>alert('you have been pwned')</script>")
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

func render() {

}

func main() {
	go http.HandleFunc("/", router)
	http.ListenAndServe(":1199", nil)
}
