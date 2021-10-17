FROM mysql

# Update and upgrade OS
RUN apt-get update && apt-get upgrade -y

# Setup the custom configuration
COPY ./mysql/config/conf.d /etc/mysql/

RUN chmod -R 0444 /etc/mysql/conf.d/*.cnf

# Environment variables 
ENV MYSQL_ROOT_PASSWORD=@mySql123
ENV MYSQL_DATABASE=thehours
ENV MYSQL_USER=admin
ENV MYSQL_PASSWORD=Admin123

# Copy content from file .sql to Docker mysql container
COPY ./script/thehours.sql /docker-entrypoint-initdb.d/

