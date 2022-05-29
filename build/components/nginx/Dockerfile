FROM nginx:1.17.1

# set the number of worker processes to the number of available CPU cores
RUN sed -i -e "s/worker_processes  1/worker_processes `cat /proc/cpuinfo |grep processor | wc -l`/" /etc/nginx/nginx.conf

# set http server config
COPY ./build/components/nginx/conf.d/*.conf /etc/nginx/conf.d/

WORKDIR /srv/training
