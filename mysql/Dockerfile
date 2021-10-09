FROM mysql

# Update and upgrade OS
RUN apt-get update && apt-get upgrade -y

# Copy content from file .sql to Docker mysql container
COPY ./script/thehours.sql /docker-entrypoint-initdb.d/init.sql