package main

import (
	"fmt"
	"html/template"
	"net"
	"net/http"
	"net/http/fcgi"
	"strings"
)

type webPageData struct {
	Code    int
	Title   string
	Content string
}

var URLPath []string
var HTTPResponse http.ResponseWriter
var WebPageTemplate *template.Template
var WebPageData webPageData

func router(httpResp http.ResponseWriter, r *http.Request) {
	fmt.Println("url: ", r.URL.Path)
	WebPageData.Content = "AAA"
	URLPath = strings.Split(r.URL.Path, "/")
	HTTPResponse = httpResp
	WebPageTemplate = template.New("main")
	WebPageTemplate, _ = WebPageTemplate.ParseFiles("../tpl/main/main.tpl")
	switch URLPath[1] {
	case "all":
		allPage()
		//	default:

	}
	//T := "<script>alert('you have been pwned')</script>"
	err := WebPageTemplate.ExecuteTemplate(HTTPResponse, "Data", WebPageData)
	if err != nil {
		fmt.Println(err)
	}
}

func thread() {

}

func section() {

}

func mainPage() {

}

func allPage() {
	//	t := template.New("some template").Parse(`Test 123`)
	//t, _ = t.ParseFiles("/home/sashko/go/tpl/main/main.tpl", nil)
	//	user := 1
	//	t.Execute(HTTPResponse, user)
	//	fmt.Println("test")
}

func errorPage(code int) {
	fmt.Println("code: ", code)
}

func render() {

}

func main() {
	test()
	go http.HandleFunc("/", router)
	//http.ListenAndServe(":1199", nil)
	listener, err := net.Listen("tcp", "127.0.0.1:9000")
	if err != nil {
		fmt.Println(err)
	}
	err = fcgi.Serve(listener, nil)
}
