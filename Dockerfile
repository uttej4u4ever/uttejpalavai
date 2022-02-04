#This is a sample Image 
FROM centos:7
MAINTAINER Uttej Kumar Palavai
LABEL Remarks="This is a dockerfile example for Centos system"
RUN yum -y update && 
RUN yum -y install httpd && 
RUN yum clean all
COPY data/httpd.conf /etc/httpd/conf/httpd.conf
ADD data/html.tar.gz /var/www/html
EXPOSE 80
ENV HOME /root
WORKDIR /root
ENTRYPOINT ["ping"]
CMD ["uttejpalavai.com"]
