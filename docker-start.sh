#!/bin/bash

# SSL
certbot renew --dry-run

# Iniciar apache
apache2-foreground