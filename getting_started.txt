Certificate Download and Installation

The included certificates and installation instructions are for Apache version HTTP Server.

BEFORE YOU BEGIN
You must have admin access to the server where you will install the certificate. If you use a hosted web service or do not have access to your server, forward this ZIP file to your host admin or technical assistant who will install your Thawte RSA certificate:
- ssl_certificate.crt
- IntermediateCA.crt
- SSLAssistant

There are two options to install your certificate. You can use the SSL Assistant to install your certificate, or install your certificate manually.

(OPTIONAL) TO USE SSL ASSISTANT TO INSTALL YOUR CERTIFICATE ON APACHE
1. Move the SSL Assistant folder onto the server where you plan to install the certificate. Log in as root and from the command line, change permissions on the file to 755 and run: ./sslassistant_installcert.sh
2. Restart the server to complete the installation.
Note: SSL Assistant does not install anything on your server and does not run as a background process. SSL Assistant does not gather or send any information from your server.


TO INSTALL YOUR CERTIFICATE
IMPORTANT! Make sure you install any intermediate CA certificates included in this ZIP file before installing your SSL certificate.

To get detailed installation instructions for your server, go to:
https://search.thawte.com/support/ssl-digital-certificates/index?page=content&id=SO25698

CHECK YOUR CERTIFICATE INSTALLATION
To test your newly installed certificate with the SSL Toolbox, go to:https://ssltools.thawte.com/checker/views/certCheck.jsp

INSTALL THAWTE TRUSTED SITE SEAL
Take advantage of the trust mark that gives customers confidence put the Thawte Trusted Site Seal on your site today! Thawte Trusted Site Seal is included with your certificate purchase.
To customize and install the seal on your web site, go to:
http://www.thawte.com/ssl/secured-seal/installation-agreement/index.html

FOR MORE ASSISTANCE
Visit our customer technical support site:
https://search.thawte.com/support/ssl-digital-certificates/index.html