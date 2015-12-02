#!/bin/bash

echo "Ensure cake is executable"
chmod +x /home/replique/opt/work/app/bin/*

echo "Flyway migrate away"
flyway migrate -url="jdbc:mysql://localhost:3306/replique" -user=root -password=password -locations="filesystem:/home/replique/opt/work/data" -sqlMigrationPrefix="Replique_"
flyway migrate -url="jdbc:mysql://localhost:3306/replique_test" -user=root -password=password -locations="filesystem:/home/replique/opt/work/data" -sqlMigrationPrefix="Replique_"