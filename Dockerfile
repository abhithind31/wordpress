FROM bitnami/wordpress:latest

# Copy custom theme files
COPY wp-content/themes /opt/bitnami/wordpress/wp-content/themes

USER 1001
