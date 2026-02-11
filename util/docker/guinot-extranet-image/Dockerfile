FROM debian:latest

MAINTAINER Sylvain Dubus <sylvain.dubus@globalis-ms.com>

# Install useful things
RUN apt-get update && \
	apt-get install -y \
		zsh \
		curl \
		git \
		vim \
		net-tools \
		cron \
		locales \
		gnupg

# Update source list
RUN echo 'deb http://packages.dotdeb.org stretch all' >> /etc/apt/sources.list && \
	echo 'deb-src http://packages.dotdeb.org stretch all' >> /etc/apt/sources.list && \
	curl -O https://www.dotdeb.org/dotdeb.gpg && \
	apt-key add dotdeb.gpg

# Install Apache and PHP
RUN apt-get update && \
	apt-get install -y \
		php7.0 \
		php7.0-cli \
		php7.0-common \
		php7.0-zip \
		php7.0-mbstring \
		php7.0-mysql \
		apache2 \
		libapache2-mod-php7.0

# Enable Apache rewrite module
RUN a2enmod rewrite

# Change Apache config
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Add server name to Apache configuration
RUN echo "ServerName $(cat /etc/hostname)" >> /etc/apache2/apache2.conf

# Install Oh My Zsh (use bash to avoid non-zero return value by install.sh :/)
RUN bash -c "$(curl -fsSL https://raw.github.com/robbyrussell/oh-my-zsh/master/tools/install.sh)"

# Change Zsh theme
RUN sed -ie 's/ZSH_THEME="robbyrussell"/ZSH_THEME="gentoo"/g' /root/.zshrc

# Make Zsh the default shell
RUN chsh -s /bin/zsh

# Copy container starter
COPY service_start.sh /home/docker/service_start.sh
RUN chmod 744 /home/docker/service_start.sh

# Copy default crontabs
COPY crontabs/* /var/spool/cron/crontabs/

# Configure default directory
WORKDIR /home/docker

# Create application folder
RUN mkdir -p /home/docker/eone
RUN mkdir -p /home/docker/log/import

# Install locales
RUN sed -i 's/^# *\(fr_FR\)/\1/' /etc/locale.gen
RUN locale-gen

# Enable Apache modules
RUN a2enmod ssl headers

# Configure Exim4
RUN rm /etc/mailname
COPY exim4/mailname /etc/mailname
RUN rm /etc/exim4/update-exim4.conf.conf
COPY exim4/update-exim4.conf.conf /etc/exim4/update-exim4.conf.conf

CMD /home/docker/service_start.sh ; sleep infinity
