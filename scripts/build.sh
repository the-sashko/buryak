#!/bin/bash
echo "Backup"
cp bin/app bin/app-backup
echo "ok!"
echo "Build project"
go build -o bin/app src/*.go
echo "ok!"
echo "Fix permissions"
chmod -x bin/app
chmod 755 bin/app
echo "ok!"
echo "Running build..."
./run.sh