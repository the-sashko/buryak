package main
import (
	"fmt"
	/*"strings"*/
	"net/http"
)

var URLPath []string

type webPage struct {
	code int
	title string
	body string
}

func start(w http.ResponseWriter, r *http.Request) {
	/*URLPath := strings.Split(r.URL.Path,"/")*/
	fmt.Fprintf(w,"Comming soon...")
}

func main() {
	http.HandleFunc("/", start)
	http.ListenAndServe(":1199", nil)
}