FROM bitnami/wordpress:latest

# Copy custom theme files
COPY wp-content/themes /opt/bitnami/wordpress/wp-content/themes

# Set permissions
RUN chown -R 1001:1001 /opt/bitnami/wordpress/wp-content

USER 1001
