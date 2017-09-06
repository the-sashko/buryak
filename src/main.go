package main

import (
	"fmt"
	"html/template"
	"net"
	"net/http"
	"net/http/fcgi"
	"strconv"
	"strings"

	"gopkg.in/mgo.v2/bson"
)

type webPageData struct {
	Code    int
	Title   string
	Content string
}

type postImage struct {
	Type string
	URI  string
	NSWF bool
	GIF  bool
}

type post struct {
	ID         int
	RelativeID int
	Title      string
	Text       string
	Media      postImage
	Pass       string
	Username   string
	Tripcode   string
	Time       int
	UPD        int
	IP         string
	IsActive   bool
}

var URLPath []string
var HTTPResponse http.ResponseWriter
var WebPageTemplate *template.Template
var WebPageData webPageData

func router(httpResp http.ResponseWriter, r *http.Request) {
	fmt.Println("url: ", r.URL.Path)
	URLPath = strings.Split(r.URL.Path, "/")
	HTTPResponse = httpResp
	WebPageTemplate = template.New("main")
	WebPageTemplate, _ = WebPageTemplate.ParseFiles("tpl/main/main.tpl")
	path := URLPath[1]
	if path == "" || path == "/" {
		path = "all"
	}
	switch path {
	case "all":
		mainPage()
	case "error":
		code := 404
		if len(URLPath) >= 4 {
			code, err := strconv.Atoi(URLPath[2])
			if err != nil && code >= 200 && code <= 511 {
				code = 404
			}
		}
		errorPage(code)
	default:
		errorPage(404)
	}
	err := WebPageTemplate.ExecuteTemplate(HTTPResponse, "Data", WebPageData)
	if err != nil {
		fmt.Println(err)
	}
}

func thread() {

}

func section() {

}

func allTreads() {

}

func mainPage() {
	dbSession := dbConnect()
	var testdata []post
	err := dbSession.DB("fajno").C("posts").Find(bson.M{}).All(&testdata)
	if err == nil {
		defer dbSession.Close()
		fmt.Println(testdata)
	} else {
		panic(err)
	}
	WebPageData.Content = "all"
}

func errorPage(code int) {
	if code == 404 && strings.Join(URLPath, "/") != "/error/404/" {
		HTTPResponse.Header().Set("Location", "/error/404/")
		HTTPResponse.WriteHeader(302)
		WebPageData.Content = "Error"
	} else {
		HTTPResponse.WriteHeader(code)
		WebPageData.Content = "error"
	}

}

func render() {

}

func main() {
	test()
	go http.HandleFunc("/", router)
	listener, err := net.Listen("tcp", "127.0.0.1:9000")
	if err != nil {
		fmt.Println(err)
	}
	err = fcgi.Serve(listener, nil)
}
