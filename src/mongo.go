package main

import (
	"fmt"

	"gopkg.in/mgo.v2"
)

func test() {
	dbSession := dbConnect()
	if dbSession != nil {
		fmt.Println("Mongo - ok!")
		defer dbSession.Close()
	} else {
		panic("Can not connect to data base!")
	}
}

func dbConnect() *mgo.Session {
	connectionString := &mgo.DialInfo{
		Addrs:    []string{"127.0.0.1:27017"},
		Database: "fajno"}
	mongoSession, err := mgo.DialWithInfo(connectionString)
	if err == nil {
		return mongoSession
	}
	return nil
}
