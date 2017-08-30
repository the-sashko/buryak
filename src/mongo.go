package main

import (
	"fmt"
	"gopkg.in/mgo.v2"
)

func test() {
	mongoDBDialInfo := &mgo.DialInfo{
		Addrs:    []string{"127.0.0.1:27017"},
		Database: "fajno",
		Username: "fajno",
		Password: "123",
	}
	mongoSession, err := mgo.DialWithInfo(mongoDBDialInfo)
	if err != nil {
		fmt.Println(err)
	} else {
		fmt.Println(mongoSession)
	}
}
